<?php

namespace App\Entity;

use App\Repository\PizzaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PizzaRepository::class)
 */
class Pizza
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ingredient1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ingredient2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ingredient3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ingredient4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ingredient5;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $createdat;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIngredient1(): ?string
    {
        return $this->ingredient1;
    }

    public function setIngredient1(string $ingredient1): self
    {
        $this->ingredient1 = $ingredient1;

        return $this;
    }

    public function getIngredient2(): ?string
    {
        return $this->ingredient2;
    }

    public function setIngredient2(?string $ingredient2): self
    {
        $this->ingredient2 = $ingredient2;

        return $this;
    }

    public function getIngredient3(): ?string
    {
        return $this->ingredient3;
    }

    public function setIngredient3(?string $ingredient3): self
    {
        $this->ingredient3 = $ingredient3;

        return $this;
    }

    public function getIngredient4(): ?string
    {
        return $this->ingredient4;
    }

    public function setIngredient4(?string $ingredient4): self
    {
        $this->ingredient4 = $ingredient4;

        return $this;
    }

    public function getIngredient5(): ?string
    {
        return $this->ingredient5;
    }

    public function setIngredient5(?string $ingredient5): self
    {
        $this->ingredient5 = $ingredient5;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedat(): ?string
    {
        return $this->createdat;
    }

    public function setCreatedat(string $createdat): self
    {
        $this->createdat = $createdat;

        return $this;
    }

}
