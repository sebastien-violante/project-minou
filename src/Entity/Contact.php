<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Contact {

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $firstname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2, max=100)
     */
    private $lastname;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(min=2)
     */
    private $message;

    public function setFirstname(string $firstname): Contact
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function setLastname(string $lastname): Contact
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function setEmail(string $email): Contact
    {
        $this->email = $email;
        return $this;
    }

    public function setMessage(?string $message): Contact
    {
        $this->message = $message;
        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

}

