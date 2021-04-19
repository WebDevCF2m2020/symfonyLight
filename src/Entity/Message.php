<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=false)
     */
    private $thetitle;

    /**
     * @ORM\Column(type="text")
     */
    private $themessage;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $thedate;

    /**
     * @ORM\ManyToOne(targetEntity=TheUser::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idtheuser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getThetitle(): ?string
    {
        return $this->thetitle;
    }

    public function setThetitle(?string $thetitle): self
    {
        $this->thetitle = $thetitle;

        return $this;
    }

    public function getThemessage(): ?string
    {
        return $this->themessage;
    }

    public function setThemessage(string $themessage): self
    {
        $this->themessage = $themessage;

        return $this;
    }

    public function getThedate(): ?\DateTimeInterface
    {
        return $this->thedate;
    }

    public function setThedate(?\DateTimeInterface $thedate): self
    {
        $this->thedate = $thedate;

        return $this;
    }

    public function getIdtheuser(): ?TheUser
    {
        return $this->idtheuser;
    }

    public function setIdtheuser(?TheUser $idtheuser): self
    {
        $this->idtheuser = $idtheuser;

        return $this;
    }
}
