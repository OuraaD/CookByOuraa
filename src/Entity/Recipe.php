<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[UniqueEntity('name')]
#[HasLifecycleCallbacks]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 50, minMessage: 'Nombre de caractère insuffisant', maxMessage: 'Nombre de caractère trop élévé')]
    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 50, minMessage: 'Nombre de caractère insuffisant', maxMessage: 'Nombre de caractère trop élévé')]
    #[ORM\Column(length: 50)]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    #[Assert\GreaterThanOrEqual(1)]
    #[Assert\LessThanOrEqual(1440)]
    private ?int $time = null;

    #[ORM\Column(nullable: true)]
    #[Assert\LessThan(50)]
    private ?int $people = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Range(min: 1, max: 5)]
    private ?int $difficulty = null;

    
    #[Assert\NotBlank()]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $step = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    #[Assert\GreaterThan(1)]
    #[Assert\LessThanOrEqual(1000)]
    private ?string $price = null;

    #[ORM\Column]
    private ?bool $favorite = false;

    #[ORM\Column]
    private ?\DateTimeImmutable $DateOfCreation = null;
    #[ORM\PrePersist]
    public function setDateOfCreationValue()
    {
        $this->DateOfCreation = new DateTimeImmutable();
    }

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $UpdateDate = null;
    #[ORM\PreUpdate]
    public function setUpdateValue()
    {
        $this->UpdateDate = new DateTimeImmutable();
    }

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\ManyToMany(targetEntity: Ingredient::class)]
    #[ORM\JoinColumn(onDelete:'SET NULL')]
    private Collection $Ingredients;

    #[ORM\Column(length: 255)]
    private ?string $FileName = null;

    public function __construct()
    {
        $this->Ingredients = new ArrayCollection();
    }

 

    public function getId(): ?int
    {
        return $this->id;
    }

  

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of slug
     */ 
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     *
     * @return  self
     */ 
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the value of time
     */ 
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */ 
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get the value of people
     */ 
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * Set the value of people
     *
     * @return  self
     */ 
    public function setPeople($people)
    {
        $this->people = $people;

        return $this;
    }

    /**
     * Get the value of difficulty
     */ 
    public function getDifficulty()
    {
        return $this->difficulty;
    }

    /**
     * Set the value of difficulty
     *
     * @return  self
     */ 
    public function setDifficulty($difficulty)
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * Get the value of step
     */ 
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Set the value of step
     *
     * @return  self
     */ 
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of favorite
     */ 
    public function getFavorite()
    {
        return $this->favorite;
    }

    /**
     * Set the value of favorite
     *
     * @return  self
     */ 
    public function setFavorite($favorite)
    {
        $this->favorite = $favorite;

        return $this;
    }

    /**
     * Get the value of DateOfCreation
     */ 
    public function getDateOfCreation()
    {
        return $this->DateOfCreation;
    }

    /**
     * Set the value of DateOfCreation
     *
     * @return  self
     */ 
    public function setDateOfCreation($DateOfCreation)
    {
        $this->DateOfCreation = $DateOfCreation;

        return $this;
    }

    /**
     * Get the value of UpdateDate
     */ 
    public function getUpdateDate()
    {
        return $this->UpdateDate;
    }

    /**
     * Set the value of UpdateDate
     *
     * @return  self
     */ 
    public function setUpdateDate($UpdateDate)
    {
        $this->UpdateDate = $UpdateDate;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->Ingredients;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->Ingredients->contains($ingredient)) {
            $this->Ingredients->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        $this->Ingredients->removeElement($ingredient);

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->FileName;
    }

    public function setFileName(string $FileName): static
    {
        $this->FileName = $FileName;

        return $this;
    }
}
