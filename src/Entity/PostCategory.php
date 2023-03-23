<?php

namespace App\Entity;

use App\Repository\PostCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostCategoryRepository::class)]
class PostCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

<<<<<<< HEAD
    #[ORM\OneToMany(mappedBy: 'categoy', targetEntity: post::class)]
    private Collection $category;

    public function __construct()
    {
        $this->category = new ArrayCollection();
=======
    #[ORM\OneToMany(mappedBy: 'postCategory', targetEntity: Post::class)]
    private Collection $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
>>>>>>> 3893d2fe6a0e0fcdff3757a759844f76ce04bfdf
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
<<<<<<< HEAD
     * @return Collection<int, post>
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(post $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category->add($category);
            $category->setCategoy($this);
=======
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setPostCategory($this);
>>>>>>> 3893d2fe6a0e0fcdff3757a759844f76ce04bfdf
        }

        return $this;
    }

<<<<<<< HEAD
    public function removeCategory(post $category): self
    {
        if ($this->category->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getCategoy() === $this) {
                $category->setCategoy(null);
=======
    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getPostCategory() === $this) {
                $post->setPostCategory(null);
>>>>>>> 3893d2fe6a0e0fcdff3757a759844f76ce04bfdf
            }
        }

        return $this;
    }
}
