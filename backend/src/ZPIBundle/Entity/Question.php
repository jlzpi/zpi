<?phpnamespace ZPIBundle\Entity;use Doctrine\ORM\EntityRepository;use Doctrine\ORM\Mapping as ORM;use ZPIBundle\Entity\Category;use Symfont\Bridge\Doctrine\Validator\Constraints\UniqueEntity;/** * @ORM\Entity(repositoryClass="ZPIBundle\Entity\QuestionRepository") * @ORM\Table(name="Question") */class Question{    /**     * @ORM\Column(type="integer")     * @ORM\Id     * @ORM\GeneratedValue(strategy="AUTO")     */    private $id;    /**     * @ORM\Column(type="string", length=100)     */    private $picture;    /**     * @ORM\Column(type="string", length=200)     */    private $question;		/**	 * @ORM\ManyToOne(targetEntity="Category", inversedBy="questions")	 * @ORM\JoinColumn(name="category", referencedColumnName="id")	 */	private $category;		/**	 * @ORM\OneToMany(targetEntity="Answer", mappedBy="question", cascade={"remove"})	 */	private $answers;	public function __construct($p, $q, $c) {		$this->picture = $p;		$this->question = $q;		$this->category = $c;		$this->answers = new \Doctrine\Common\Collections\ArrayCollection();	}		public function getId() {		return $this->id;	}	public function getPicture() {		return $this->picture;	}		public function getQuestion() {		return $this->question;	}		public function getCategory() {		return $this->category;	}			public function setPicture($picture) {		$this->picture = $picture;	}		public function setQuestion($question) {		$this->question = $question;	}		public function setCategory($category) {		$this->category = $category;	}		public function getAnswers() {		return $this->answers;	}}