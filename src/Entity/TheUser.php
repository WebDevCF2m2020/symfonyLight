<?php

namespace App\Entity;

use App\Repository\TheUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
// on veut utiliser cette classe pour la gestion d'utilisateur
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=TheUserRepository::class)
 */
class TheUser implements UserInterface {

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

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thepwd;

    /**
     * @ORM\Column(type="json")
     */
    private $theroles = [];

    public function __construct() {
        $this->messages = new ArrayCollection();
    }

    // ce qu'on veut afficher quand l'objet doit être vu en tant que string
    public function __toString() {
        return $this->getThemail();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getThename(): ?string {
        return $this->thename;
    }

    public function setThename(string $thename): self {
        $this->thename = $thename;

        return $this;
    }

    public function getThemail(): ?string {
        return $this->themail;
    }

    public function setThemail(string $themail): self {
        $this->themail = $themail;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessages(): Collection {
        return $this->messages;
    }

    public function addMessage(Message $message): self {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setIdtheuser($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getIdtheuser() === $this) {
                $message->setIdtheuser(null);
            }
        }

        return $this;
    }

    public function eraseCredentials() {
        
    }

    public function getPassword() {
        return $this->thepwd;
    }

    public function getRoles(): array {
        return $this->theroles;
    }

    public function getSalt() {
        
    }

    public function getUsername(): string {
        // on va renvoyer son équivalent dans notre table
        return $this->thename;
    }

    public function getThepwd(): ?string
    {
        return $this->thepwd;
    }

    public function setThepwd(string $thepwd): self
    {
        $this->thepwd = $thepwd;

        return $this;
    }

    public function getTheroles(): ?array
    {
        return $this->theroles;
    }

    public function setTheroles(array $theroles): self
    {
        $this->theroles = $theroles;

        return $this;
    }

}
