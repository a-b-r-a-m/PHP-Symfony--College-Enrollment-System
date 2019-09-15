<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentSubjectRepository")
 */
class StudentSubject
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="studentSubjects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="App\Entity\Subject", inversedBy="studentSubjects")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subject;

    /**
     * @Assert\Choice({"enrolled", "passed"})
     * @ORM\Column(type="string", length=8)
     */
    private $status;

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function __toString()    //only subject name
    {
        return $this->getSubject()->getIme();
    }
}
