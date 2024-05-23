<?php

namespace App\Controller;

use App\DTO\PurchaseRequest;
use App\Service\PaymentService;
use App\DTO\CalculatePriceRequest;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Service\PriceCalculationService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PurchaseProductController  extends AbstractController
{
    private $priceCalculationService;
    private $paymentService;
    private $productRepository;
    private $couponRepository;

    public function __construct(
        PriceCalculationService $priceCalculationService,
        PaymentService $paymentService,
        ProductRepository $productRepository,
        CouponRepository $couponRepository
    ) {
        $this->priceCalculationService = $priceCalculationService;
        $this->paymentService = $paymentService;
        $this->productRepository = $productRepository;
        $this->couponRepository = $couponRepository;
    }


    #[Route('/purchase', methods: ['POST'], name: 'purchase')]
    public function purchase(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $purchaseRequest = new PurchaseRequest();
        $purchaseRequest->product = $data['product'] ?? null;
        $purchaseRequest->taxNumber = $data['taxNumber'] ?? null;
        $purchaseRequest->couponCode = $data['couponCode'] ?? null;
        $purchaseRequest->paymentProcessor = $data['paymentProcessor'] ?? null;

        $errors = $validator->validate($purchaseRequest);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getPropertyPath() . ': ' . $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], 400);
        }

        $product = $this->productRepository->find($purchaseRequest->product);
        if (!$product) {
            return new JsonResponse(['error' => 'Product not found'], 400);
        }

        $coupon = $this->couponRepository->findOneBy(['code' => $purchaseRequest->couponCode]);

        try {
            $price = $this->priceCalculationService->calculatePrice($product, $coupon, $purchaseRequest->taxNumber);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        try {
            $success = $this->paymentService->processPayment($purchaseRequest->paymentProcessor, $price);
        } catch (\InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }

        if (!$success) {
            return new JsonResponse(['error' => 'Payment failed'], 400);
        }

        return new JsonResponse(['message' => 'Payment successful'], 200);
    }
}