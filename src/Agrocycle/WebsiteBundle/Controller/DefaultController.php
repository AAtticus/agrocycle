<?php

namespace Agrocycle\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ivory\GoogleMapBundle\Model\Overlays\Animation;
use Ivory\GoogleMapBundle\Model\Events\MouseEvent;


class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return  $this->render('AgrocycleWebsiteBundle:Default:index.html.twig');
    }
    
    /**
     * @Route("/pioniers")
     * @Template()
     */
    public function pioniersAction()
    {
        
        $repository = $this->getDoctrine()->getRepository('AgrocycleAgrocycleBundle:Organisation');
        $organisations = $repository->findAll();
        
        $map = $this->get('ivory_google_map.map');
        
        //$map->setCenter($organisation->getLocation()->getLattitude(), $organisation->getLocation()->getLongitude(), true);
        
        // Disable the auto zoom flag
        $map->setAutoZoom(false);

        // Sets the center
        $map->setCenter(52.070497800000000000, 4.300699900000040500, true);

        // Sets the zoom
        $map->setMapOption('zoom', 7);
        
        $map->setStylesheetOptions(array(
            'width' => '100%',
            'height' => '500px'
        ));
        
        $markerImage = $this->get('ivory_google_map.marker_image');

        // Configure your marker image options
        $markerImage->setPrefixJavascriptVariable('marker_image_');
        $markerImage->setUrl('http://i.imgur.com/HQl8a1Q.png');
        $markerImage->setAnchor(0, 0);
        $markerImage->setOrigin(0, 0);
        $markerImage->setSize(66, 56, "px", "px");
        $markerImage->setScaledSize(33, 27, "px", "px");
        
        foreach($organisations as $organisation)
        {
            
            $content = "<h4>".$organisation->getName()."</h4>";
            $content .= "<a href=\"".$this->generateUrl('agrocycle_website_default_pionierdetail', array('id' => $organisation->getId(), 'slug' => $organisation->getSlug()))."\" class=\"secondary medium button\">Bezoek deze pionier</a>";
            
            // Requests the ivory google map info window service
            $infoWindow = $this->get('ivory_google_map.info_window');

            // Configure your info window options
            $infoWindow->setPrefixJavascriptVariable('info_window_');
            $infoWindow->setPosition($organisation->getLocation()->getLattitude(), $organisation->getLocation()->getLongitude(), true);
            $infoWindow->setPixelOffset(1.1, 2.1, 'px', 'pt');
            $infoWindow->setContent($content);
            $infoWindow->setOpen(false);
            $infoWindow->setAutoOpen(true);
            $infoWindow->setOpenEvent(MouseEvent::CLICK);
            $infoWindow->setAutoClose(true);
            $infoWindow->setOption('disableAutoPan', false);
            $infoWindow->setOption('zIndex', 10);
  
            
            $map->addInfoWindow($infoWindow);
            
             // Requests the ivory google map marker service
            $marker = $this->get('ivory_google_map.marker');

            $marker->setPrefixJavascriptVariable('marker_');
            $marker->setPosition($organisation->getLocation()->getLattitude(), $organisation->getLocation()->getLongitude(), true);
            $marker->setAnimation(Animation::DROP);
            
            $marker->setIcon($markerImage);

            $marker->setOptions(array(
                'clickable' => true,
                'flat' => false
            ));

            $marker->setInfoWindow($infoWindow);
            
            $map->addMarker($marker);
        }
        
        return  $this->render('AgrocycleWebsiteBundle:Default:pioniers.html.twig', array('map' => $map, 'organisations' => $organisations));
    }
    
    /**
     * @Route("/pioniers/{slug}/{id}")
     * @Template()
     */
    public function pionierdetailAction()
    {
        return  $this->render('AgrocycleWebsiteBundle:Default:pioniersdetail.html.twig');
    }
    
}
