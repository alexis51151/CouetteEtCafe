<?php

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\Entity\Owner;
use App\Entity\Client;
use App\Entity\Region;
use App\Entity\Room;
use App\Entity\Commentaire;


class UserFixtures extends Fixture
{
         private $passwordEncoder;
         public const IDF_REGION_REFERENCE = 'idf-region';
    
         public function __construct(UserPasswordEncoderInterface $passwordEncoder)
         {
             $this->passwordEncoder = $passwordEncoder;
        }
        
    public function load(ObjectManager $manager)
    {
        $this->LoadUsers($manager);
        $manager->flush();
        
        $this->loadRooms($manager);

        $manager->flush();
    }
    
    
    public function loadRooms(ObjectManager $manager)
    {
        $owners = $manager->getRepository(Owner::class)->findByFamilyName('owner1@localhost');
        
        $region = new Region();
        $region->setCountry("FR");
        $region->setName("Ile de France");
        $region->setPresentation("La région française capitale");
        $manager->persist($region);
        
        $manager->flush();
        // Une fois l'instance de Region sauvée en base de données,
        // elle dispose d'un identifiant généré par Doctrine, et peut
        // donc être sauvegardée comme future référence.
        $this->addReference(self::IDF_REGION_REFERENCE, $region);
        
        // ...
        
        $room = new Room();
        $room->setSummary("Beau poulailler ancien à Évry");
        $room->setDescription("très joli espace sur paille");
        $room->setOwner($owners[0]);
        //$room->addRegion($region);
        // On peut plutôt faire une référence explicite à la référence
        // enregistrée précédamment, ce qui permet d'éviter de se
        // tromper d'instance de Region :
        $room->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
        $commentaire = new Commentaire();
        $commentaire->setRoom($room);
        $commentaire->setContenu("Was are delightful solicitude discovered collecting man day. Resolving neglected sir tolerably but existence conveying for. Day his put off unaffected literature partiality inhabiting.");
        $manager->persist($commentaire);
        $manager->persist($room);
        
        $room = new Room();
        $room->setSummary("Seconde room en idf");
        $room->setDescription("Seconde description");
        $room->setOwner($owners[0]);
        //$room->addRegion($region);
        // On peut plutôt faire une référence explicite à la référence
        // enregistrée précédamment, ce qui permet d'éviter de se
        // tromper d'instance de Region :
        $room->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
        $manager->persist($room);
        
        
        $owners = $manager->getRepository(Owner::class)->findByFamilyName('owner2@localhost');
        $room = new Room();
        $room->setSummary("Colloc à Évry");
        $room->setDescription("Chambre dans un trois pièces à Évry");
        $room->setOwner($owners[0]);
        //$room->addRegion($region);
        // On peut plutôt faire une référence explicite à la référence
        // enregistrée précédamment, ce qui permet d'éviter de se
        // tromper d'instance de Region :
        $room->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
        $manager->persist($room);
        
    }
    
    private function loadUsers(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$email,$plainPassword,$role]) {
            $user = new User();
            $encodedPassword = $this->passwordEncoder->encodePassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPassword($encodedPassword);
            $user->addRole($role);
            if ($role == 'ROLE_OWNER') {
                $owner = new Owner();
                $owner->setFamilyName($email);
                $manager->persist($owner);
                $user->setOwner($owner);
            }
             
            if ($role == 'ROLE_CLIENT') {
                $client = new Client();
                $client->setFamilyName($email);
                $manager->persist($client);
                $user->setClient($client);
            }
            $manager->persist($user);
        }
    }
    
    private function getUserData()
    {
        yield ['chris@localhost','chris','ROLE_USER'];
        yield ['anna@localhost','anna','ROLE_ADMIN'];
        yield ['owner1@localhost','owner1','ROLE_OWNER'];
        yield ['owner2@localhost','owner2','ROLE_OWNER'];
        yield ['client@localhost','client','ROLE_CLIENT'];
        
    }
}
