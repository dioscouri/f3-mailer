<?php
namespace Mailer\Models;

class Events extends \Dsc\Mongo\Collections\Describable
{
    protected $__collection_name = 'mailer.events';
    protected $__type = 'core';

    public $slug = null;
    public $title = null;
                         
    // these are being used
    public $event_name = null;
    public $event_subject = null;
    public $event_html = null;
    public $event_text = null;

    protected $__config = array(
        'default_sort' => array(
            'app' => 1,
            'title' => 1
        )
    );

    protected function fetchConditions()
    {
        parent::fetchConditions();
        
        $filter_namespace = $this->getState('filter.namespace');
        if (strlen($filter_namespace))
        {
            $this->setCondition('namespace', $filter_namespace);
        }
        
        return $this;
    }

    public static function register($eventName, array $options = [], array $content = [])
    {
        // Add the email event to the collection if it isn't already
        $event = (new static())->setCondition('event_name', $eventName)->getItem();
        if (empty($event->id))
        {
            try
            {
                $event = new static();
                
                $event->bind(array(
                    'event_name' => $eventName
                ))
                    ->bind($options)
                    ->bind($content)
                    ->save();
                
                // create the first template?
                /*
                 * $content = $content + ['title' => 'Default', 'copy' => 'Default From Application'];
                 * $model = (new \Mailer\Models\Templates);
                 * $model->set('event_id',$event->id);
                 * $model->bind($content);
                 * $model->save();
                 */
                return $event;
            }
            catch (\Exception $e)
            {
                echo $e->getMessage();
                die();
                return false;
            }
        }
        else
        {
            // update the default values for the event
            $event->bind($options)
                ->bind($content)
                ->save();
        }
        
        return true;
    }

    /**
     * Gets the content Variant based off settings
     */
    public function getTemplate()
    {
        try
        {
            // Implement the round-robin logic here 
            // to return the template least recently used 
            $templates = (new \Mailer\Models\Templates)
                ->setState('filter.event', $this->id)
                ->setState('filter.publication_status', 'published')
                ->setState('list.sort', array('last_used' => 1))
                ->setState('list.limit', 1)
                ->getItems();
            
            $template = null;
            if (!empty($templates)) {
                $template = $templates[0];
            }
            
            if (empty($template->id)) {
                $template = $this;
            } else {
                $template->set('last_used', time())->save();
            }
            
            if (empty($template->event_html))
            {
                throw new \Exception('Content is empty, or no Template for this event');
            }
            
            return $template;
            
        }
        catch (Exception $e)
        {
            // throw the error up the stack
            throw new \Exception($e->getMessage());
        }
    }

    public function getRenderedContent()
    {
        $template = $this->getTemplate();
        
        $subject = \Mailer\Render::instance()->resolve($template->event_subject);
        $html = \Mailer\Render::instance()->resolve($template->event_html);
        $text = \Mailer\Render::instance()->resolve($template->event_text);
        
        return [
            'subject' => $subject,
            'body' => [
                $html,
                $text
            ],
            'fromEmail' => $template->from_email ? $template->from_email : null,
            'fromName' => $template->from_name ? $template->from_name : null
        ];
    }

    protected function beforeValidate()
    {
        if (empty($this->slug))
        {
            $this->slug = \Web::instance()->slug($this->namespace);
        }
        
        // TODO Put this in beforeSave, to ensure that the slug is clean
        // $this->slug = \Web::instance()->slug( $this->slug );
        
        return parent::beforeValidate();
    }

    /**
     *
     * @return Ambigous <multitype:multitype: , unknown>
     */
    public function grouped()
    {
        $grouped = array();
        
        if ($items = $this->getItems())
        {
            foreach ($items as $item)
            {
                if (empty($grouped[$item->type]))
                {
                    $grouped[$item->type] = array();
                }
                
                $grouped[$item->type][] = $item;
            }
        }
        
        return $grouped;
    }
}