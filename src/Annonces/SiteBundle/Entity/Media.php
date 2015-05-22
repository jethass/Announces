<?php

namespace Annonces\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Media
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Annonces\SiteBundle\Repository\MediaRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Media
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

   /**
     * @var string $fileName
     *
     * @ORM\Column(name="file_name", type="string", length=45, nullable=true)
     * @Assert\NotBlank(message = "Prière de sélectionner une image.")
     */
    protected $fileName;


    /**
     * @var mixed $file
     *
     * @Assert\File(maxSize="2097152")
     */
    protected $file;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }


    /**
     * Set fileName
     *
     * @param string $fileName
     * @return Asset
     */
    public function setFileName($fileName) {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName() {
        return $this->fileName;
    }


    /**
     * Set file
     *
     * @param mixed $file
     * @return Picture
     */
    public function setFile($file) {
        if (is_file($this->getAbsolutePath())) {
            unlink($this->getAbsolutePath());
        }
        $this->file = $file;
        try {
            $this->fileName = sha1(uniqid(mt_rand(), true)) . '.' . $file->guessExtension();
            $this->mimeType = $file->getClientMimeType();
        } catch (\Exception $e) {

        }
        return $this;
    }

    /**
     * Get file
     *
     * @return mixed
     */
    public function getFile() {
        return $this->file;
    }

    public function getAbsolutePath() {
        return null === $this->fileName ? null : $this->getUploadRootDir() . '/' . $this->fileName;
    }

    public function getWebPath() {
        if(file_exists($this->getUploadRootDir()  . '/' . $this->fileName)):
            return null === $this->fileName ? null : '/' . $this->getUploadDir()  . '/' . $this->fileName;
        else:
            return "http://dummyimage.com/200x136/EFEFEF/AAAAAA&text=no.image";
        endif;
    }

    public function getRelativePath() {
        return null === $this->fileName ? null : $this->getUploadDir() . '/' . $this->fileName;
    }

    public function getUploadRootDir() {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
       // if($this->getMimeType() == 'image/png' || $this->getMimeType() == 'image/jpeg' || $this->getMimeType() == 'image/gif'):
            return 'uploads/files';
      //  endif;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function upload() {
        if (null === $this->file) {
            return;
        }
        if ($this->file) {
            //try {
            $this->updatedAt = new \DateTime();
            $this->file->move($this->getUploadRootDir(), $this->fileName);
            // } catch (\Exception $e) {

            // }
            $this->file = null;
        }
    }

    /**
     * @ORM\PreRemove
     */
    public function removeUpload() {
        if (is_file($file = $this->getAbsolutePath())) {
            unlink($file);
        }
    }

}
