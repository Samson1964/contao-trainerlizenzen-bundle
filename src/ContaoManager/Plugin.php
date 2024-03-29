<?php

namespace Schachbulle\ContaoTrainerlizenzenBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Schachbulle\ContaoTrainerlizenzenBundle\ContaoTrainerlizenzenBundle;

class Plugin implements BundlePluginInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function getBundles(ParserInterface $parser)
	{
		return [
			BundleConfig::create(ContaoTrainerlizenzenBundle::class)
				->setLoadAfter([ContaoCoreBundle::class]),
		];
	}
}
