<?php

namespace App\Controller;

use App\DTO\CalculatePriceRequest;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Service\PriceCalculationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CalculatePriceController extends AbstractController
{

    public function __construct(
        private PriceCalculationService $priceCalculationService,
        private ProductRepository $productRepository,
        private CouponRepository $couponRepository
    ) {
        $this->priceCalculationService = $priceCalculationService;
        $this->productRepository = $productRepository;
        $this->couponRepository = $couponRepository;
    }

    #[Route('/calculate-price', methods: ['POST'], name: 'calculate_price')]
    public function calculate(Request $request, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent(), true);
        $calculatePriceRequest = new CalculatePriceRequest();
        $calculatePriceRequest->product = $data['product'] ?? null;
        $calculatePriceRequest->taxNumber = $data['taxNumber'] ?? null;
        $calculatePriceRequest->couponCode = $data['couponCode'] ?? null;

        $errors = $validator->validate($calculatePriceRequest);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getPropertyPath() . ': ' . $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], 400);
        }

        $product = $this->productRepository->find($calculatePriceRequest->product);
        if (!$product) {
            return new JsonResponse(['error' => 'Product not found'], 400);
        }

        $coupon = $this->couponRepository->findOneBy(['code' => $calculatePriceRequest->couponCode]);

        try {
            $price = $this->priceCalculationService->calculatePrice($product, $coupon, $calculatePriceRequest->taxNumber);
            return new JsonResponse(['price' => $price], 200);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }
    }
}
