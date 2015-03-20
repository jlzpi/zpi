<?phpnamespace ZPIBundle\Entity;use Doctrine\ORM\EntityRepository;use Doctrine\ORM\Mapping as ORM;use ZPIBundle\Entity\Question;/** * @ORM\Entity(repositoryClass="ZPIBundle\Entity\QuestionRepository") * @ORM\Table(name="Category") */class Category{    /**     * @ORM\Column(type="integer")     * @ORM\Id     * @ORM\GeneratedValue(strategy="AUTO")     */    private $id;    /**     * @ORM\Column(type="string", length=100)     */    private $name;		/**	 * @ORM\OneToMany(targetEntity="Question", mappedBy="category")	 */	private $questions;	 	public function __construct() {		 $this->questions = new \Doctrine\Common\Collections\ArrayCollection();	}		public function getId() {		return $this->id;	}		public function getName() {		return $this->name;	}		public function getQuestions() {		return $this->questions;	}		public function setId($id) {		$this->id = $id;	}		public function setName($name) {		$this->name = $name;	}		public function setQuestions($questions) {		$this->questions = $questions;	}}