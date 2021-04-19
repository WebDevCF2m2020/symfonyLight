<?php

namespace App\Entity;

use App\Repository\TheUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TheUserRepository::class)
 */
class TheUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $thename;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $themail;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="idtheuser", orphanRemoval=true)
     */
    private $messages;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }
    
    // ce qu'on veut afficher quand l'objet doit être vu en tant que string
    public function __toString() {
        return $this->getThemail();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getThename(): ?string
    {
        return $this->thename;
    }

    public function setThename(string $thename): self
    {
        $this->thename = $thename;

        return $this;
    }

    public function getThemail(): ?string
    {
        return $this->themail;
    }

    public function setThemail(string $themail): self
    {
        $this->themail = $themail;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setIdtheuser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getIdtheuser() === $this) {
                $message->setIdtheuser(null);
            }
        }

        return $this;
    }
}
