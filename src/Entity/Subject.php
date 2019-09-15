<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubjectRepository")
 */
class Subject
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Unesite ime predmeta.")
     * @ORM\Column(type="string", length=60)
     */
    private $ime;

    /**
     * @Assert\NotBlank(message="Unesite kod predmeta")
     * @Assert\Regex(
     *     pattern="/(^([A-Z]{3})([0-9]{3})$)|(^([A-Z]{4})([0-9]{2})$)/",
     *     message="Kod mora imati biti u formatu 'NPR123' ili 'ABCD12'")
     * @ORM\Column(type="string", length=6, unique=true)
     */
    private $kod;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $program;

    /**
     * @Assert\NotBlank(message="Predmet mora nositi određeni broj bodova.")
     * @Assert\Range(
     *     max=30,
     *     maxMessage="Predmet može nositi maksimalno 30 ECTS bodova.")
     * @ORM\Column(type="smallint")
     */
    private $bodovi;

    /**
     * @Assert\NotBlank(message="Nije specificiran semestar u kojem se predmet održava.")
     * @Assert\Range(
     *     min=1,
     *     max=6,
     *     maxMessage="Redovni studenti imaju samo 6 semestara.")
     * @ORM\Column(type="smallint")
     */
    private $sem_redovni;

    /**
     * @Assert\NotBlank(message="Nije specificiran semestar u kojem se predmet održava.")
     * @Assert\Range(
     *     min=1,
     *     max=8,
     *     maxMessage="Izvanredni studenti imaju samo 8 semestara.")
     * @ORM\Column(type="smallint")
     */
    private $sem_izvanredni;

    /**
     * @ORM\Column(type="boolean")
     */
    private $izborni;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudentSubject", mappedBy="subject", orphanRemoval=true)
     */
    private $studentSubjects;

    public function __construct()
    {
        $this->studentSubjects = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getIme();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIme(): ?string
    {
        return $this->ime;
    }

    public function setIme(string $ime): self
    {
        $this->ime = $ime;

        return $this;
    }

    public function getKod(): ?string
    {
        return $this->kod;
    }

    public function setKod(string $kod): self
    {
        $this->kod = $kod;

        return $this;
    }

    public function getProgram(): ?string
    {
        return $this->program;
    }

    public function setProgram(string $program): self
    {
        $this->program = $program;

        return $this;
    }

    public function getBodovi(): ?int
    {
        return $this->bodovi;
    }

    public function setBodovi(int $bodovi): self
    {
        $this->bodovi = $bodovi;

        return $this;
    }

    public function getSemRedovni(): ?int
    {
        return $this->sem_redovni;
    }

    public function setSemRedovni(int $sem_redovni): self
    {
        $this->sem_redovni = $sem_redovni;

        return $this;
    }

    public function getSemIzvanredni(): ?int
    {
        return $this->sem_izvanredni;
    }

    public function setSemIzvanredni(int $sem_izvanredni): self
    {
        $this->sem_izvanredni = $sem_izvanredni;

        return $this;
    }

    public function getIzborni(): ?bool
    {
        return $this->izborni;
    }

    public function setIzborni(bool $izborni): self
    {
        $this->izborni = $izborni;

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
            $studentSubject->setSubject($this);
        }

        return $this;
    }

    public function removeStudentSubject(StudentSubject $studentSubject): self
    {
        if ($this->studentSubjects->contains($studentSubject)) {
            $this->studentSubjects->removeElement($studentSubject);
            // set the owning side to null (unless already changed)
            if ($studentSubject->getSubject() === $this) {
                $studentSubject->setSubject(null);
            }
        }

        return $this;
    }
}
