<?phpnamespace ZPIBundle\Entity;

use Doctrine\ORM\EntityRepository;
use JMS\Serializer\Annotation\Groups;use Doctrine\ORM\Mapping as ORM;use ZPIBundle\Entity\Category;use ZPIBundle\Entity\Statistics;use Symfont\Bridge\Doctrine\Validator\Constraints\UniqueEntity;/** * @ORM\Entity(repositoryClass="ZPIBundle\Entity\QuestionRepository") * @ORM\Table(name="Question") */class Question{    /**     * @ORM\Column(type="integer")     * @ORM\Id     * @ORM\GeneratedValue(strategy="AUTO")
	 * @Groups({"question","question_with_answers"})     */    private $id;    /**     * @ORM\Column(type="string", length=100)
	 * @Groups({"question","question_with_answers"})     */    private $picture;    /**     * @ORM\Column(type="string", length=200)
	 * @Groups({"question","question_with_answers"})     */    private $question;		/**	 * @ORM\ManyToOne(targetEntity="Category", inversedBy="questions")	 * @ORM\JoinColumn(name="category", referencedColumnName="id")	 */	private $category;		/**
	 * @ORM\OneToMany(targetEntity="Answer", mappedBy="question", cascade={"persist","remove"})
	 * @Groups({"question_with_answers"})	 */	private $answers;	/**	 * @ORM\OneToMany(targetEntity="Statistics", mappedBy="question")	 */	private $statistics;		public function __construct($p, $q, $c) {		$this->picture = $p;		$this->question = $q;		$this->category = $c;		$this->answers = new \Doctrine\Common\Collections\ArrayCollection();		$this->statistics = new \Doctrine\Common\Collections\ArrayCollection();	}		public function getId() {		return $this->id;	}	public function getPicture() {		return $this->picture;	}		public function getQuestion() {		return $this->question;	}		public function getCategory() {		return $this->category;	}			public function setPicture($picture) {		$this->picture = $picture;	}		public function setQuestion($question) {		$this->question = $question;	}		public function setCategory($category) {		$this->category = $category;	}		public function getAnswers() {		return $this->answers;	}		public function getStatistics() {		return $this->statistics;	}
	
	public function resetAnswers() {
		$this->answers = new \Doctrine\Common\Collections\ArrayCollection();
	}
	
	public function addAnswer($answer) {
		$this->answers[] = $answer;
	}}
