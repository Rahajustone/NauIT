<?php 

namespace App\EventListener;

use Doctrine\Persistence\Event\LifecycleEventArgs;

/**
 * 
 */
class AddHistoryListener
{
	/**
	 * Posts a persist.
	 *
	 * @param      \Doctrine\Persistence\Event\LifecycleEventArgs  $args   The arguments
	 */
	public function postPersist(LifecycleEventArgs $args)
	{
		// dump($args);

		// die("I am here");
	}

	public function prePost(LifecycleEventArgs $args)
	{
		return $args;
	}

}