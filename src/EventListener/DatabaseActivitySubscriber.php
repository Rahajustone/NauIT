<?php

namespace App\EventListener;

use App\Entity\LogDatabaseChanges;
use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\EntityManagerInterface;
// use Doctrine\ORM\EntityManager;

/**
 * This class describes a database activity subscriber.
 */
class DatabaseActivitySubscriber implements EventSubscriber
{
    // public function __construct(EntityManagerInterface $em){

    // }

    //
    // this method can only return the event names; you cannot define a custom
    // method name to execute when each event triggers
    //
    // @return     array  The subscribed events.
    //
    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            // Events::postRemove,
            // Events::postUpdate,
            // Events::preUpdate,
        ];
    }

    //
    // callback methods must be called exactly like the events they listen to;
    // they receive an argument of type LifecycleEventArgs, which gives you
    // access to both the entity object of the event and the entity manager
    // itself
    //
    // @param LifecycleEventArgs
    //
    public function postPersist(LifecycleEventArgs $args)
    {
        $entityManager = $args->getObjectManager();
        $entity = $args->getEntity();


        try {
            $logDatabaseChange =  new LogDatabaseChanges();
            $logDatabaseChange->setMessage("text");
            // $logDatabaseChange->setContext($array);

            $entityManager->persist($logDatabaseChange);
            $entityManager->flush($logDatabaseChange);
            
        } catch (Exception $e) {
            // $this->log("error".$e->getMessage());
        }



        // dump($entity);
        // $array = array($entity);

        // dump($array);
        // dump(serialize($entity));
        // dump(json_encode($array[0]));



        // dump($entity->getName());
        // die();
        

        // $this->logActivity('persist', $args);
    }

    /**
     * Posts a remove.
     *
     * @param LifecycleEventArgs
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $this->logActivity('remove', $args);
    }

    /**
     * { function_description }
     *
     * @param LifecycleEventArgs
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->logActivity('update', $args);
    }


    /**
     * Posts an update.
     *
     * @param LifecycleEventArgs
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->logActivity('update', $args);
    }

    /**
     * @param  string
     * @param  LifecycleEventArgs
     * @return [type]
     */
    private function logActivity(string $action, LifecycleEventArgs $args)
    {
        $entityManager = $args->getObjectManager();
        $entity = $args->getEntity();



        // dump($entity);
        $array = array($entity);

        // dump($array);
        // dump(serialize($entity));
        // dump(json_encode($array[0]));



        // dump($entity->getName());
        // die();
        $logDatabaseChange =  new LogDatabaseChanges();
        $logDatabaseChange->setMessage("tet");
        // $logDatabaseChange->setContext($array);

        $entityManager->persist($logDatabaseChange);
        $entityManager->flush();

        // // if this subscriber only applies to certain entity types,
        // // add some code to check the entity type as early as possible
        // if (!$entity instanceof Product) {
        //     return;
        // }

        // ... get the entity information and log it somehow
    }
}
