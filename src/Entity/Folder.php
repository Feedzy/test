<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FolderRepository")
 */
class Folder
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /*
    *@ORM\Column(type="string", length=255)
    */
    private $nom;


    /**
     * Many Documents have one (the same) Folder
     * @ORM\OneToMany(targetEntity="Document", mappedBy="folder", cascade={"persist"}, orphanRemoval=true)
     */
	private $documents;


    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * Add document
     *
     * @param \Playground\CookiejarBundle\Entity\Document $document
     *
     * @return Folder
     */
    public function addDocument(\Playground\CookiejarBundle\Entity\Document $document)
    {
        // Bidirectional Ownership
        $document->setFolder($this);
        
        $this->documents[] = $document;
        
        return $this;
    }
    
    /**
     * Remove document
     *
     * @param \Playground\CookiejarBundle\Entity\Document $document
     */
    public function removeDocument(\Playground\CookiejarBundle\Entity\Document $document)
    {
        $this->documents->removeElement($document);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get /*
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set /*
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }
}
