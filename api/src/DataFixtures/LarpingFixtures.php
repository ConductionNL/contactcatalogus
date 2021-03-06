<?php

namespace App\DataFixtures;

use App\Entity\Email;
use App\Entity\Organization;
use App\Entity\Social;
use Conduction\CommonGroundBundle\Service\CommonGroundService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class LarpingFixtures extends Fixture
{
    private $params;
    /**
     * @var CommonGroundService
     */
    private $commonGroundService;

    public function __construct(ParameterBagInterface $params, CommonGroundService $commonGroundService)
    {
        $this->params = $params;
        $this->commonGroundService = $commonGroundService;
    }

    public function load(ObjectManager $manager)
    {
        if (
            !$this->params->get('app_build_all_fixtures') &&
            $this->params->get('app_domain') != 'larping.eu' && strpos($this->params->get('app_domain'), 'larping.eu') == false
        ) {
            return false;
        }

        $id = Uuid::fromString('58a681b0-7ff8-4b42-98c0-eef371117d4a');
        $website = new Social();
        $website->setName('Website van Vortex Adventures');
        $website->setDescription('Vortex Adventures');
        $website->setType('website');
        $website->setUrl('http://www.the-vortex.nl');
        $manager->persist($website);
        $website->setId($id);
        $manager->persist($website);
        $manager->flush();
        $website = $manager->getRepository('App:Social')->findOneBy(['id'=> $id]);

        $id = Uuid::fromString('8cca7475-f157-4430-91ae-a5afb8e98dd1');
        $instagram = new Social();
        $instagram->setName('Instagram van Vortex Adventures');
        $instagram->setDescription('Vortex Adventures');
        $instagram->setType('instagram');
        $instagram->setUrl('https://www.instagram.com/vortex.adventures/');
        $manager->persist($instagram);
        $instagram->setId($id);
        $manager->persist($instagram);
        $manager->flush();
        $instagram = $manager->getRepository('App:Social')->findOneBy(['id'=> $id]);

        $id = Uuid::fromString('b75935c3-ea0e-4b75-9ff4-e3344a1f21c2');
        $facebook = new Social();
        $facebook->setName('Facebook van Vortex Adventures');
        $facebook->setDescription('Vortex Adventures');
        $facebook->setType('facebook');
        $facebook->setUrl('https://www.facebook.com/VortexAdventures');
        $manager->persist($facebook);
        $facebook->setId($id);
        $manager->persist($facebook);
        $manager->flush();
        $facebook = $manager->getRepository('App:Social')->findOneBy(['id'=> $id]);

        $email1 = new Email();
        $email1->setName('Email van de voorzitter van Vortex Adventures');
        $email1->setEmail('voorzitterva@gmail.com');
        $manager->persist($email1);
        $manager->flush();

        $email2 = new Email();
        $email2->setName('Email van de secretaris van Vortex Adventures');
        $email2->setEmail('vasecretaris@gmail.com');
        $manager->persist($email2);
        $manager->flush();

        // Vortex
        $id = Uuid::fromString('c69a9073-9d72-4743-ad33-3c4c7fb34589');
        $organization = new Organization();
        $organization->setName('Vortex Adventures');
        $organization->setDescription('Vortex Adventures');
        $organization->setSourceOrganization($this->commonGroundService->cleanUrl(['component'=>'wrc', 'type'=>'organizations', 'id'=>'e62b32b5-2d1f-4412-9eb7-225bce414d05']));
        $manager->persist($organization);
        $organization->setId($id);
        $manager->persist($organization);
        $manager->flush();
        $organization = $manager->getRepository('App:Organization')->findOneBy(['id'=> $id]);
        $organization->addSocial($website);
        $organization->addSocial($instagram);
        $organization->addSocial($facebook);
        $organization->addEmail($email1);
        $organization->addEmail($email2);
        $manager->persist($organization);
        $manager->flush();

//        $id = Uuid::fromString('f13c6c4c-047d-4c2a-b2ea-8bb798c90190');
//        $website = new Social();
//        $website->setName('Website van Conduction');
//        $website->setDescription('Conduction');
//        $website->setType('website');
//        $website->setUrl('https://www.conduction.nl');
//        $manager->persist($website);
//        $website->setId($id);
//        $manager->persist($website);
//        $manager->flush();
//        $website = $manager->getRepository('App:Social')->findOneBy(['id'=> $id]);
//
        $id = Uuid::fromString('a2177b92-56e0-4edf-9af2-8b98eb2aea0e');
        $organization = new Organization();
        $organization->setName('Conduction');
        $organization->setDescription('Conduction organisatie');
        $manager->persist($organization);
        $organization->setId($id);
        $manager->persist($organization);
        $manager->flush();
        $organization = $manager->getRepository('App:Organization')->findOneBy(['id'=> $id]);
        $organization->addSocial($website);
        $manager->persist($organization);
        $manager->flush();
    }
}
