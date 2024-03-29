<?php

namespace Lynda\MagazineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Issue
 *
 * @ORM\Table(name="issues")
 * @ORM\Entity(repositoryClass="Lynda\MagazineBundle\Entity\IssueRepository")
 */
class Issue
{

    /**
     * @var Publication
     *
     * @ORM\ManyToOne(targetEntity="Publication", inversedBy="issues")
     * @ORM\JoinColumn(name="publication_id", referencedColumnName="id")
     *
     */


    private $publication;


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     *
     *
     * @Assert\Range(
     * min=1,
     * minMessage = "You will need to specify Issue 1 or higher."
     * )
     */
    private $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="date")
     *
     *
     */
    private $datePublication;

    /**
     * @var string
     *
     * @ORM\Column(name="cover", type="string", length=255, nullable=true)
     */
    private $cover;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Issue
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     * @return Issue
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime 
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set cover
     *
     * @param string $cover
     * @return Issue
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return string 
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set publication
     *
     * @param \Lynda\MagazineBundle\Entity\Publication $publication
     * @return Issue
     */
    public function setPublication(\Lynda\MagazineBundle\Entity\Publication $publication = null)
    {
        $this->publication = $publication;

        return $this;
    }

    /**
     * Get publication
     *
     * @return \Lynda\MagazineBundle\Entity\Publication 
     */
    public function getPublication()
    {
        return $this->publication;
    }



    /**
     * get web path to upload directory.
     *
     * @return string
     *  Relative path.
     *
     */

    protected function getUploadPath(){
        return 'uploads\covers';
    }

    /**
     * get absolute path to upload directory.
     *
     * @return string
     *  absolute path.
     *
     */

    protected function getUploadAbsolutePath(){
        return __DIR__.'/../../../../web/'.$this->getUploadPath();
    }

    /**
     * get path to a cover.
     *
     * @return null|string
     *  relative path.
     *
     */
    public function getCoverWeb(){
        return NULL === $this->getCover()
            ? NULL
            :$this->getUploadPath().'/'.$this->getCover();
    }


    /**
     * get absolute path to a cover.
     *
     * @return null|string
     *  absolute path.
     *
     */
    public function getCoverAbsolute(){
        return NULL === $this->getCover()
            ? NULL
            :$this->getUploadAbsolutePath().'/'.$this->getCover();
    }

    /**
     * @Assert\File(maxSize="1000000")
     *
     */


    private $file;
    /**
     * Sets file.
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     */

    public function setFile(UploadedFile $file= NULL){
        $this->file=$file;
    }


    /**
     * Gets file.
     * @return UploadedFile
     */

    public function getFile(){
        return $this->file;
    }

    /**
     *
     * upload cover.
     */


    public function upload(){
        //File property can be empty
        if(NULL=== $this->getFile()){
            return;
        }

        $filename = $this->getFile()->getClientOriginalName();

        //Move the uploaded file to target directory using original name.

        $this->getFile()->move(
            $this->getUploadAbsolutePath(),
            $filename);

        //set the cover.

        $this->setCover($filename);

        //Cleanup

        $this->setFile();
    }
}
