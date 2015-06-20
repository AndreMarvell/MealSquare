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
use MealSquare\RecetteBundle\Entity\Recette;

/**
 * Description of ImportAeroportCommand
 *
 * @author ikounga_marvel
 */
class ImportRecetteCommand extends ContainerAwareCommand{
    
    private $ingredient_repository ;
    private $recette_repository;
    private $em ;


    protected function configure()
    {
        $this
            ->setName('recettes:import')
            ->setDescription('Import de quelques recettes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $lettres = array(/*'a','b','c','d','e','f','g','h',*/'i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        
        $this->em = $this->getContainer()->get('doctrine')->getManager();
        $this->ingredient_repository = $this->em->getRepository('MealSquareRecetteBundle:Ingredient');
        $this->recette_repository = $this->em->getRepository('MealSquareRecetteBundle:Recette');
        
        foreach ($lettres as $lettre){
            for ($i=0;$i<=5;$i++){
                
                $url = "http://madame.lefigaro.fr/recettes/liste/".$lettre."?page=".$i;
        
                echo PHP_EOL.PHP_EOL.'Import des recettes commencant par "'.$lettre.'", Page N°:'.($i+1).PHP_EOL.' URL: "'.$url.'"'.PHP_EOL.PHP_EOL;
                
                $acurl = new acurl();
                $acurl->set_option('url',$url);
                $acurl->set_option('user_agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:27.0) Gecko/20100101 Firefox/27.0');
                $answer = $acurl->http_request();

                preg_match('/<div class="view-content">(.*)<h2 class="element-invisible">Pages<\/h2>/isU', $answer, $matches);
                if(isset($matches[1])){
                    preg_match_all(
                        '/<div class="mad__listing--recette__row__media">(?:.*)<a href="(.*)">(?:.*)<img/isU', 
                        $matches[1],
                        $recettes);

                    foreach ($recettes[1] as $link){
                        $this->getRecipe("http://madame.lefigaro.fr".$link);
                    }
                }else{
                    echo PHP_EOL.'Il n\' y a aucune recette sur cette page'.PHP_EOL;
                }
            }
        }
    }
    
    private function getRecipe($url){
         
        $acurl = new acurl();
        $acurl->set_option('url',$url);
        $acurl->set_option('user_agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:27.0) Gecko/20100101 Firefox/27.0');
        $answer = $acurl->http_request();

        preg_match('/<img[ ]+srcset="(.*)[ ]+\d+w"(?:.*)<h1 class="mad__titre" itemprop="name">(.*)<\/h1>(?:.*)<div class="mad-head-info__auteur" itemprop="recipeCategory">(?:.*)<a href="(?:.*)">(.*)<\/a>(?:.*)<ul class="recette-infos">(.*)<\/ul>(?:.*)<span itemprop="recipeYield">pour (.*)(?:personne|personnes)?<\/span>(?:.*)<ul class="recette-infos">(.*)<\/ul><\/div>(?:.*)<section class="mad__recette-content">(?:.*)<div class="article-body" title="(?:.*)" itemprop="recipeInstructions">(.*)<\/div>/isU',
                $answer,
                $matches);
        
        if(!isset($matches[1]) || is_null($matches[1])){
            echo PHP_EOL.'Import de la recette à l\'url "'.$url.'" a échoué'.PHP_EOL;
            return;
        }
            
        
        $image = $matches[1];
        $titre = $matches[2];
        $categorie = trim($matches[3]);
        
        // On recupere le temps de preparation
        preg_match('/<li(?: class="first")?>Préparation : (.*)<\/li>/isU', $matches[4], $info);
        $preparation = (isset($info[1]) && !is_null($info[1]))? $info[1]:null;
        
        // On recupere le temps de cuisson
        preg_match('/<li(?: class="first")?>Cuisson : (.*)<\/li>/isU', $matches[4], $info);
        $cuisson = (isset($info[1]) && !is_null($info[1]))? $info[1]:null;

        // On recupere la difficulté
        preg_match('/<li(?: class="first")?>Difficulté : <a href="(?:.*)">(.*)<\/a><\/li>/isU', $matches[4], $info);
        $difficulte = (isset($info[1]) && !is_null($info[1]))? $info[1]:null;
        
        // On recupere la saison
        preg_match('/<li>Saison : <a href="(?:.*)">(.*)<\/a><\/li>/isU', $matches[4], $info);
        $saison = (isset($info[1]) && !is_null($info[1]))? $info[1]:null;
        
        // On recupere la specialite
        preg_match('/<li class="last">Spécialité : <a href="(?:.*)">(.*)<\/a><\/li>/isU', $matches[4], $info);
        $specialite = (isset($info[1]) && !is_null($info[1]))? $info[1]:null;
        
        $nbPersonne = $matches[5];
        $ingredients = $matches[6];
        $recette_content = $matches[7];
        
        $recette = $this->recette_repository->findOneByTitre($titre);
               
        if($recette instanceof Recette){
            echo 'Import de la recette "'.$recette->getTitre().'" déjà réalisé '.PHP_EOL;
        }else{
            $recette = new Recette();
                                   
            $recette->setSource("Lefigaro.fr")
                    ->setNbPersonne($nbPersonne)
                    ->setSaison($saison)
                    ->setTitre($titre)
                    ->setTempsCuisson($this->getNbMinute($cuisson))
                    ->setTempsPreparation($this->getNbMinute($preparation))
                    ->setFullIngredients($ingredients)
                    ->setDifficulte($difficulte)
                    ->setSpecialite($specialite)
                    ->setVisibilite(true)
                    
            ;
            
            // On traite la catégorie
            $repCat = $this->em->getRepository('ApplicationSonataClassificationBundle:Category');
            $recipeCat = $repCat->findOneByName($categorie);
            
            if($recipeCat instanceof \Application\Sonata\ClassificationBundle\Entity\Category){
                $recette->setCategorie($recipeCat);
            }
            
            $this->em->persist($recette);
            $this->em->flush();
            
            $recette->createThread();
            
            // On traite les differentes parties de la recette
            $return = preg_match_all('/<p>(.*)<\/p>/isU', $recette_content,$recette_blocks);
            
            if($return != false && $return>0){
                foreach ($recette_blocks[1] as $blocks){
                    $rb = new \MealSquare\RecetteBundle\Entity\InfosBlock();
                    $rb ->setDescription($blocks)
                        ->setRecette($recette);

                    $recette->addRecetteBlock($rb);
                }
            }else{
                $rb = new \MealSquare\RecetteBundle\Entity\InfosBlock();
                $rb ->setDescription($recette_content)
                    ->setRecette($recette);

                $recette->addRecetteBlock($rb);
            }
            
            
            // On recupere l'image
            $media = $this->downloadFile($image, $titre);
            $recette->setImage($media);
            
            $this->em->persist($recette);
            $this->em->flush();
            
            echo 'Import de la recette "'.$recette->getTitre().'" réalisé avec succès'.PHP_EOL;
        }        
        
        
        
    }
    
    private function getNbMinute($time) {
        
        preg_match('/(?:.*(\d+) h )?(\d+) min/isU',$time, $t);
        
        $heure = (isset($t[1]) && !is_null($t[1]))? $t[1]:0;
        $minute = (isset($t[2]) && !is_null($t[2]))? $t[2]:0;
        
        return $minute + $heure*60;
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
        $media->setContext('recette');
        $media->setProviderName('sonata.media.provider.image');
        $media->setName($nom);
        $media->setAuthorName("Lefigaro.fr");
        $media->setCopyright("© madame.lefigaro.fr");
         
        $this->getContainer()->get('sonata.media.manager.media')->save($media);
        
        if ($file) 
            fclose($file);
        if ($newf) 
            fclose($newf);
        
        unlink($newfname);

        return $media;
    }
}

