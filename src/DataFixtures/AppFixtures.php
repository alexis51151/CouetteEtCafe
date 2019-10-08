<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Region;
use App\Entity\Owner;
use App\Entity\Room;
use Doctrine\Common\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
    // définit un nom de référence pour une instance de Region
    public const IDF_REGION_REFERENCE = 'idf-region';
    
    public function load(ObjectManager $manager)
    {
        //...
        
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
                
        $room = new Room();
        $room->setSummary("Beau poulailler ancien à Évry");
        $room->setDescription("très joli espace sur paille");
        $room->addRegion($region);
        // On peut plutôt faire une référence explicite à la référence
        // enregistrée précédamment, ce qui permet d'éviter de se
        // tromper d'instance de Region :
        //$room->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
        $room->setCapacity(2);
        $room->setSuperficy(2);
        $room->setPrice(2);
        
        
        $manager->persist($room);
        $manager->flush();
        
        $room2 = new Room();
        $room2->setSummary("Beau poulailler ancien à Évry VERSION 2");
        $room2->setDescription("très joli espace sur paille VERSION 2");
        $room2->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
        $room2->setCapacity(3);
        $room2->setSuperficy(2);
        $room->setPrice(2);
        $manager->persist($room2);
        
        $manager->flush();
        
        //...
    }
    
    //...
}