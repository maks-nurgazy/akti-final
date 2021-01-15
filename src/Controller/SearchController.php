<?php


namespace App\Controller;



use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SearchController
 * @package App\Controller
 * @Route("")
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/search",name="search_page")
     * @param Request $request
     * @return Response
     */
    public function search()
    {

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('app_searchlist'))
            ->add('SearchBy',ChoiceType::class,[
                'choices'=>[
                    'by name'=>'name',
                    'by price'=>'price',
                    'by date'=>'data',
                    'by description'=>'description'
                ]
            ])
            ->add('query',TextType::class,[
                'attr'=>[
                    'placeholder'=>'Search',
                    'autocomplete'=>'off',
                    'class'=>'search',
                ],
                'method'=>'POST',
                'action'=>$this->generateUrl('app_searchlist')
            ])
            ->add('submit',SubmitType::class,[
                'attr'=>[
                    'class'=>"btn"
                ]
            ])
            ->getForm();

        return $this->render('searchht/search.html.twig',[
            'product_form'=> $form->createView()
        ]);

    }
    /**
     * @Route("/search/list",name="app_searchlist")
     */
    public function handleSearch(Request $request, ProductRepository $productRepository){
        $query = $request->get('form')['query'];
        $filter = $request->get('form')['SearchBy'];
        if($query){
            $products = $this->getDoctrine()
                ->getRepository(Product::class)
                ->findByFilter($query, $filter);
        }
        return $this->render('searchht/searchlist.html.twig',[
            'products'=>$products
        ]);
    }

}