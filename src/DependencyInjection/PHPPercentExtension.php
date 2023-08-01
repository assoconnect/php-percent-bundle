<?php

declare(strict_types=1);

namespace AssoConnect\PHPPercentBundle\DependencyInjection;

use AssoConnect\PHPPercentBundle\Doctrine\DBAL\Types\PercentType;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class PHPPercentExtension extends Extension
{
    public function prepend(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig(
            'doctrine',
            [
            'dbal' => [
                'types' => [
                    'percent' => PercentType::class,
                ],
                'mapping_types' => [
                    'percent' => 'integer',
                ],
            ],
            ]
        );
    }

    /**
     * @param array<mixed> $configs
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        // Loading config.yml file
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../../config')
        );
        $loader->load('services.yaml');
    }
}
