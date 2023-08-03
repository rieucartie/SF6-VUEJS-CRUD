<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class ProductController extends AbstractController
{
    public function __construct(
        private ProductRepository $productRepository,
        private SerializerInterface $serializer,
        private EntityManagerInterface  $entityManager
    )
    {

    }

    #[Route('/products/view/search', name: 'products.search')]
    public function search(Request $request, SerializerInterface $serializer): Response
    {

        $searchQuery = $request->query->get('search');

        $products = $this->productRepository->searchByKeyword($searchQuery);

        $responseData = $serializer->serialize($products, 'json');

        return $this->json($responseData);

    }


    #[Route('/products', name: 'products.list')]
    public function readAll(Request $request,SerializerInterface $serializer): Response
    {

        $products = $this->productRepository->findAll();

        $responseData = $serializer->serialize($products, 'json');

        return $this->json($responseData);
    }

    #[Route('/products/create', name: 'product.add')]
    public function add(Request $request,SerializerInterface $serializer) : JsonResponse
    {

        $product = new Product();

        $jsonData = json_decode($request->getContent());

        $user = $this->productRepository->create($jsonData);

        return new JsonResponse([
            'product' => $this->serializer->serialize($product, 'json'),
            'message' => 'Produit ajouter avec succès !',
            201
        ]);
    }

    #[Route('/products/delete/{id}', name: 'product.delete')]
    public function delete(Request $request,SerializerInterface $serializer,$id)
    {

        $product = $this->productRepository->find($id);

        $this->entityManager->remove($product);

        $this->entityManager->flush();

        return $this->redirectToRoute('products.list');

    }

    #[Route('/products/edit/{id}', name: 'product.edit')]
    public function edit(Request $request,SerializerInterface $serializer,$id) : JsonResponse
    {

        $Data = $this->productRepository->find($id);

        return $this->json($this->serializer->serialize($Data, 'json'));

    }


    #[Route('/products/update/{id}', name: 'product.update')]
    public function update(Request $request,Product $product,SerializerInterface $serializer,$id) : JsonResponse
    {

        $productOldData = $this->productRepository->find($id);

        $oldId=$productOldData->getId();


        $productnewData = json_decode($request->getContent());

         $this->productRepository->update($productnewData, $oldId);

        return $this->json($this->serializer->serialize($productnewData, 'json'));

    }


}
