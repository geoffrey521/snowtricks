<?php

namespace App\Factory;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Image>
 *
 * @method static      Image|Proxy createOne(array $attributes = [])
 * @method static      Image[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static      Image|Proxy find(array|mixed|object $criteria)
 * @method static      Image|Proxy findOrCreate(array $attributes)
 * @method static      Image|Proxy first(string $sortedField = 'id')
 * @method static      Image|Proxy last(string $sortedField = 'id')
 * @method static      Image|Proxy random(array $attributes = [])
 * @method static      Image|Proxy randomOrCreate(array $attributes = [])
 * @method static      Image[]|Proxy[] all()
 * @method static      Image[]|Proxy[] findBy(array $attributes)
 * @method static      Image[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static      Image[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static      ImageRepository|RepositoryProxy repository()
 * @method Image|Proxy create(array|callable $attributes = [])
 */
final class ImageFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'title' => self::faker()->text(40),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            ->afterInstantiate(
                function (Image $image): void {
                    $img = self::faker()->file(__DIR__.'/../DataFixtures/Images/tricks/', __DIR__.'/../../public/images/trick/', false);
                    $image->setPath($img);
                    $image->setCaption('picture of '.$image->getTitle());
                }
            )
        ;
    }

    protected static function getClass(): string
    {
        return Image::class;
    }
}
