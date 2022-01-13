<?php

namespace App\Factory;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<User>
 *
 * @method static User|Proxy createOne(array $attributes = [])
 * @method static User[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static User|Proxy find(object|array|mixed $criteria)
 * @method static User|Proxy findOrCreate(array $attributes)
 * @method static User|Proxy first(string $sortedField = 'id')
 * @method static User|Proxy last(string $sortedField = 'id')
 * @method static User|Proxy random(array $attributes = [])
 * @method static User|Proxy randomOrCreate(array $attributes = [])
 * @method static User[]|Proxy[] all()
 * @method static User[]|Proxy[] findBy(array $attributes)
 * @method static User[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static User[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static UserRepository|RepositoryProxy repository()
 * @method User|Proxy create(array|callable $attributes = [])
 */
final class UserFactory extends ModelFactory
{
    public function __construct(private UserPasswordHasherInterface $encoder)
    {
        parent::__construct();
    }

    protected function getDefaults(): array
    {
        return [
            'email' => self::faker()->safeEmail(),
            'firstname' => self::faker()->firstName,
            'lastname' => self::faker()->lastName,
            'verifiedAt' => self::faker()->boolean(70) ? \DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-2 months', '-1 month')) : null,
            'agreedTermsAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-3 months', '-2 months')),
        ];
    }

    protected function initialize(): self
    {
        return $this
            ->afterInstantiate(
                function(User $user) {
                    $user->setPassword(
                        $this->encoder->hashPassword($user,'pass')
                    );
                })
        ;
    }

    protected static function getClass(): string
    {
        return User::class;
    }
}
