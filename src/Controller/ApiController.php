<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
    /**
     * @var integer HTTP status code - 200 (OK) by default
     */
    protected int $statusCode = 200;

    /**
     * Gets the value of statusCode.
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Sets the value of statusCode.
     */
    protected function setStatusCode($statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Returns a JSON response
     */
    public function response(array $data, array $headers = []): JsonResponse
    {
        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }

    /**
     * Sets an error message and returns a JSON response
     */
    public function respondWithErrors(string $errors, array $headers = []): JsonResponse
    {
        $data = [
            'status' => $this->getStatusCode(),
            'errors' => $errors,
        ];

        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }


    /**
     * Sets an error message and returns a JSON response
     */
    public function respondWithSuccess(string $success, array $headers = []): JsonResponse
    {
        $data = [
            'status' => $this->getStatusCode(),
            'success' => $success,
        ];

        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }


    /**
     * Returns a 401 Unauthorized http response
     */
    public function respondUnauthorized(string $message = 'Not authorized!'): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)->respondWithErrors($message);
    }

    /**
     * Returns a 422 Unprocessable Entity
     */
    public function respondValidationError(string $message = 'Validation errors'): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)->respondWithErrors($message);
    }

    /**
     * Returns a 404 Not Found
     */
    public function respondNotFound(string $message = 'Not found!'): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithErrors($message);
    }

    /**
     * Returns a 201 Created
     */
    public function respondCreated(array $data = []): JsonResponse
    {
        return $this->setStatusCode(Response::HTTP_CREATED)->response($data);
    }

    // this method allows us to accept JSON payloads in POST requests
    // since Symfony 4 doesn’t handle that automatically:

    protected function transformJsonBody(Request $request): Request
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}
