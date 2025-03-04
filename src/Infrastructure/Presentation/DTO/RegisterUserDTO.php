<?php

namespace App\Infrastructure\Presentation\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterUserDTO
{
    /**
     * @Assert\NotBlank(message="Name cannot be blank", groups={"registration"})
     */
    public $name;

    /**
     * @Assert\NotBlank(message="Email cannot be blank", groups={"registration"})
     * @Assert\Email(message="The email '{{ value }}' is not a valid email.", groups={"registration"})
     */
    public $email;

    /**
     * @Assert\NotBlank(message="Password cannot be blank", groups={"registration"})
     * @Assert\Length(min=8, minMessage="Your password must be at least {{ limit }} characters long", groups={"registration"})
     */
    public $password;
}