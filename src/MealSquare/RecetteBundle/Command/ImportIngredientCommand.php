<?php


namespace MealSquare\RecetteBundle\Command;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Application\Sonata\MediaBundle\Entity\Media;
use MealSquare\RecetteBundle\Entity\Ingredient;
use MealSquare\CommonBundle\Entity\acurl;

/**
 * Description of ImportAeroportCommand
 *
 * @author ikounga_marvel
 */
class ImportIngredientCommand extends ContainerAwareCommand{
    
    protected function configure()
    {
        $this
            ->setName('ingredients:import')
            ->setDescription('Importer la liste des ingrédients en cuisine')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $em = $this->getContainer()->get('doctrine')->getManager();
        $repository = $em->getRepository('MealSquareRecetteBundle:Ingredient');
        
        $url = "http://cuisine.larousse.fr/lecon-experts/ingredients/rechercher?z=1000";
        
        $acurl = new acurl();
        $acurl->set_option('url',$url);
        $acurl->set_option('user_agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:27.0) Gecko/20100101 Firefox/27.0');
        $answer = $acurl->http_request();
                
        preg_match('/<div class="Result">(.*)<div class="SortWrap">/isU', $answer, $matches);
        preg_match_all(
                '/<p class="ProductLink3"><a href="(.*)">(?:.*)<\/a>(?:.*)<\/p>/isU', 
                $matches[1],
                $ingredients);
                
        foreach ($ingredients[1] as $value) {
            
            $acurl->set_option('url',"http://cuisine.larousse.fr".$value);
            $acurl->set_option('user_agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:27.0) Gecko/20100101 Firefox/27.0');
            $detail_answer = $acurl->http_request();
            
            preg_match(
                '/<div class="Detail">(?:.*)<h1 class="title">(.*)<\/h1><p>(.*)<\/p>(?:.*)<div class="PhotoItem"><img src="(.*)"(?:.*)<div class="Option OptionBottom">/isU', 
                $detail_answer,
                $detail_ingredient);
                    
            $nom = $detail_ingredient[1];
            $image = $detail_ingredient[3]; 
            $description = $detail_ingredient[2];
                    
            $ingredient = $repository->findOneByLibelle($nom);
               
            if($ingredient instanceof Ingredient){
                echo 'Import de l\'ingrédient "'.$ingredient->getLibelle().'" déjà réalisé '.PHP_EOL;
            }else{
                // On recupère l'image
                $media = $this->downloadFile($image, $nom);

                // On enregistre l'ingrédient
                $ingredient = new Ingredient();
                $ingredient->setLibelle($nom)
                           ->setDescription($description)
                           ->setImage($media);

                $em->persist($ingredient);
                $em->flush();


                echo 'Import de l\'ingrédient "'.$nom.'" réalisé avec succès'.PHP_EOL;
            }
                           
        }
  
    }
    
    private function downloadFile ($url, $nom) {

        $newfname = __DIR__.'/../../../../web/uploads/temp/'.basename($url);
        $file = fopen ($url, "rb");
        
        if ($file) {
          $newf = fopen ($newfname, "wb");

          if ($newf)
          while(!feof($file)) {
            fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
          }
        }

        $media = new Media;
        $media->setBinaryContent($newfname);
        $media->setContext('ingredient');
        $media->setProviderName('sonata.media.provider.image');
        $media->setName($nom);
        $media->setAuthorName("Larousse");
        $media->setCopyright("© Cuisine.Larouse.fr");
         
        $this->getContainer()->get('sonata.media.manager.media')->save($media);
        
        if ($file) 
            fclose($file);
        if ($newf) 
            fclose($newf);
        
        unlink($newfname);

        return $media;
    }
}

