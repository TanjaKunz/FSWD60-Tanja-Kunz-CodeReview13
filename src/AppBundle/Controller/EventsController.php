<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use AppBundle\Entity\Events;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EventsController extends Controller
{
	/**
	 * @Route ("/", name="events")
	 */
	public function eventsAction(Request $request)
	{
		$events = $this->getDoctrine()->getRepository('AppBundle:Events')->findAll();

		return $this->render('events/index.html.twig', array('events' => $events));
	}

	/**
	 * @Route("/events/add", name="event_add")
	 */
	public function addAction(Request $request)
	{
		$event = new Events;

		$form = $this->createFormBuilder($event)
			->add('name', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('date_time', DateTimeType::class, array('attr'=>array('style'=>'margin-bottom:15px')))
			->add('description', TextareaType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('image', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('capacity', TextType::class,array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('email', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('phoneNumber', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('street', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('city', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('url', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('type', ChoiceType::class, array('choices'=>array('Music'=>'Music', 'Sport'=>'Sport', 'Movie'=>'Movie', 'Theater'=>'Theater', 'Art'=>'Art'), 'attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('save', SubmitType::class, array('label'=>'Create Todo', 'attr'=>array('class'=>'btn btn-info', 'style'=>'margin-bottom:15px')))
			->getForm();

		$form -> handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$name = $form['name']->getData();
			$date = $form['date_time']->getData();
			$description = $form['description']->getData();
			$image = $form['image']->getData();
			$capacity = $form['capacity']->getData();
			$email = $form['email']->getData();
			$phone = $form['phoneNumber']->getData();
			$street = $form['street']->getData();
			$city = $form['city']->getData();
			$url = $form['url']->getData();
			$type = $form['type']->getData();

			$event->setName($name);
			$event->setDateTime($date);
			$event->setDescription($description);
			$event->setImage($image);
			$event->setCapacity($capacity);
			$event->setEmail($email);
			$event->setPhoneNumber($phone);
			$event->setStreet($street);
			$event->setCity($city);
			$event->setUrl($url);
			$event->setType($type);

			$em = $this->getDoctrine()->getManager();
			$em -> persist($event);
			$em -> flush();

			$this -> addFlash(
				'notice',
				'Event Added'
			);

			return $this->redirectToRoute('events');
		}

		return $this->render('events/add.html.twig', array('form' => $form->createView()));
	}

	/**
	 * @Route("/events/view/{id}", name="event_view")
	 */
	public function viewAction($id)
	{
		$event = $this->getDoctrine()->getRepository('AppBundle:Events')->find($id);

		return $this->render('events/view.html.twig', array('event' => $event));
	}

	/**
	 * @Route("/events/edit/{id}", name="event_edit")
	 */
	public function editAction($id, Request $request)
	{
		$event = $this->getDoctrine()->getRepository('AppBundle:Events')->find($id);

		$event->setName($event->getName());
		$event->setDateTime($event->getDateTime());
		$event->setDescription($event->getDescription());
		$event->setImage($event->getImage());
		$event->setCapacity($event->getCapacity());
		$event->setEmail($event->getEmail());
		$event->setPhoneNumber($event->getPhoneNumber());
		$event->setStreet($event->getStreet());
		$event->setCity($event->getCity());
		$event->setUrl($event->getUrl());
		$event->setType($event->getType());

		$form = $this->createFormBuilder($event)
			->add('name', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('date_time', DateTimeType::class, array('attr'=>array('style'=>'margin-bottom:15px')))
			->add('description', TextareaType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('image', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('capacity', TextType::class,array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('email', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('phoneNumber', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('street', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('city', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('url', TextType::class, array('attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('type', ChoiceType::class, array('choices'=>array('Music'=>'Music', 'Sport'=>'Sport', 'Movie'=>'Movie', 'Theater'=>'Theater', 'Art'=>'Art'), 'attr'=>array('class'=>'form-control', 'style'=>'margin-bottom:15px')))
			->add('save', SubmitType::class, array('label'=>'Edit Event', 'attr'=>array('class'=>'btn btn-info', 'style'=>'margin-bottom:15px')))
			->getForm();

		$form -> handleRequest($request);

		if($form->isSubmitted() && $form->isValid()){
			$name = $form['name']->getData();
			$date = $form['date_time']->getData();
			$description = $form['description']->getData();
			$image = $form['image']->getData();
			$capacity = $form['capacity']->getData();
			$email = $form['email']->getData();
			$phone = $form['phoneNumber']->getData();
			$street = $form['street']->getData();
			$city = $form['city']->getData();
			$url = $form['url']->getData();
			$type = $form['type']->getData();

			$em = $this->getDoctrine()->getManager();
			$event = $em->getRepository('AppBundle:Events')->find($id);

			$event->setName($name);
			$event->setDateTime($date);
			$event->setDescription($description);
			$event->setImage($image);
			$event->setCapacity($capacity);
			$event->setEmail($email);
			$event->setPhoneNumber($phone);
			$event->setStreet($street);
			$event->setCity($city);
			$event->setUrl($url);
			$event->setType($type);

			$em->flush();

			$this->addFlash(
				'notice',
				'Event Updated'
			);

			return $this->redirectToRoute('events');
		}

		return $this->render('events/edit.html.twig', array('event' => $event, 'form' => $form->createView()));
	}

	/**
	 * @Route("/events/delete/{id}", name="event_delete")
	 */
	public function deleteAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$event = $em->getRepository('AppBundle:Events')->find($id);

		$em->remove($event);
		$em->flush();

		$this->addFlash(
			'notice',
			'Event removed'
		);

		return $this->redirectToRoute('events');
	}
}