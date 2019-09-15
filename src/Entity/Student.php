<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
class Student
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="E-mail je obavezan.")
     * @Assert\Email(message = "E-mail '{{ value }}' nije ispravan.")
     * @Assert\Regex(
     *     pattern="/(@oss.unist.hr)$/",
     *     message="E-mail mora biti u formatu 'primjer@oss.unist.hr'")
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Lozinka je obavezna.")
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @Assert\NotBlank(message="Je li osoba mentor ili student?")
     * @Assert\Choice({"student", "mentor"},
     *     message="Osoba mora biti ili 'mentor' ili 'student'")
     * @ORM\Column(type="string", length=7)
     */
    private $role;

    /**
     * @Assert\Choice({"redovan", "izvanredan", ""},
     *     message="Ako je osoba student, treba biti 'redovan ili 'izvanredan', ako je mentor ostaviti prazno.")
     * @ORM\Column(type="string", length=10)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentSubject", mappedBy="student", orphanRemoval=true)
     */
    private $studentSubjects;

    public function __construct()
    {
        $this->studentSubjects = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getEmail();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|StudentSubject[]
     */
    public function getStudentSubjects(): Collection
    {
        return $this->studentSubjects;
    }

    public function addStudentSubject(StudentSubject $studentSubject): self
    {
        if (!$this->studentSubjects->contains($studentSubject)) {
            $this->studentSubjects[] = $studentSubject;
            $studentSubject->setStudent($this);
        }

        return $this;
    }

    public function removeStudentSubject(StudentSubject $studentSubject): self
    {
        if ($this->studentSubjects->contains($studentSubject)) {
            $this->studentSubjects->removeElement($studentSubject);
            // set the owning side to null (unless already changed)
            if ($studentSubject->getStudent() === $this) {
                $studentSubject->setStudent(null);
            }
        }

        return $this;
    }
}
