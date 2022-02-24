<?php

namespace App\Factory;

use App\Entity\Video;
use App\Repository\VideoRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Video>
 *
 * @method static      Video|Proxy createOne(array $attributes = [])
 * @method static      Video[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static      Video|Proxy find(array|mixed|object $criteria)
 * @method static      Video|Proxy findOrCreate(array $attributes)
 * @method static      Video|Proxy first(string $sortedField = 'id')
 * @method static      Video|Proxy last(string $sortedField = 'id')
 * @method static      Video|Proxy random(array $attributes = [])
 * @method static      Video|Proxy randomOrCreate(array $attributes = [])
 * @method static      Video[]|Proxy[] all()
 * @method static      Video[]|Proxy[] findBy(array $attributes)
 * @method static      Video[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static      Video[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static      VideoRepository|RepositoryProxy repository()
 * @method Proxy|Video create(array|callable $attributes = [])
 */
final class VideoFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'url' => self::faker()->randomElement(['https://www.youtube.com/watch?v=LWUfrwCofuA', 'https://www.youtube.com/watch?v=_hxLS2ErMiY', 'https://www.youtube.com/watch?v=duCwYpZ_--4']),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Video $video): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Video::class;
    }
}
