<?php

namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\OpenApi;
use ApiPlatform\OpenApi\Model;
use ArrayObject;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator('api_platform.openapi.factory')]
class JwtDecorator implements OpenApiFactoryInterface
{
    public function __construct(
        private OpenApiFactoryInterface $decorated,
    ) {
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $schemas = $openApi->getComponents()->getSchemas();

        if (!$schemas) {
            return $openApi;
        }

        $schemas['Credentials'] = new ArrayObject([
            'type' => 'object',
            'description' => 'Les identifiants de l\'utilisateur',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'johndoe@example.com',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'apassword',
                ],
            ],
        ]);

        $pathItem = new Model\PathItem(
            ref: 'JWT Token',
            post: new Model\Operation(
                operationId: 'postCredentialsItem',
                tags: ['User'],
                responses: [
                    '200' => [
                        'description' => 'Utilisateur authentifié',
                        'headers' => [
                            'Set-Cookie' => [
                                'description' => 'Un cookie contenant la signature (http-only), un cookie contenant le payload',
                                'schema' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                    ],
                    '401' => [
                        'description' => 'Mauvais identifiants',
                    ],
                ],
                summary: 'Authentifie un utilisateur auprès de l\'API.',
                requestBody: new Model\RequestBody(
                    description: 'Les identifiants de l\'utilisateur',
                    content: new ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Credentials',
                            ],
                        ],
                    ]),
                ),
            ),
        );
        $openApi->getPaths()->addPath('/users/login', $pathItem);

        return $openApi;
    }
}
