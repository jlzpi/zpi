<?phpnamespace ZPIBundle\DataFixtures\ORM;use Doctrine\Common\DataFixtures\AbstractFixture;use Doctrine\Common\DataFixtures\OrderedFixtureInterface;use Doctrine\Common\Persistence\ObjectManager;use ZPIBundle\Entity\Question;class LoadQuestionData extends AbstractFixture implements OrderedFixtureInterface{    /**     * {@inheritDoc}     */    public function load(ObjectManager $em)    {		$questions = array(			new Question('pictures/1.jpg', 'Where\'s a cat?', $this->getReference('categoryPrzyimki')),			new Question('pictures/1.jpg', 'What\'s on the table?', $this->getReference('categoryRzeczy')),						new Question('pictures/2.jpg', 'Where are the pictures?', $this->getReference('categoryPrzyimki')),						new Question('pictures/3.jpg', 'Where is the crocodile?', $this->getReference('categoryPrzyimki')),			new Question('pictures/3.jpg', 'What\'s under the bed?', $this->getReference('categoryZwierzeta')),						new Question('pictures/4.jpg', 'What can you see in the picture?', $this->getReference('categoryRzeczy')),						new Question('pictures/5.jpg', 'What can you see in the picture?', $this->getReference('categoryRzeczy')),						new Question('pictures/6.jpg', 'What can you see in the picture?', $this->getReference('categoryRzeczy')),			new Question('pictures/6.jpg', 'Where\'s a blackboard?', $this->getReference('categoryPrzyimki')),			new Question('pictures/6.jpg', 'Where are benches?', $this->getReference('categoryPrzyimki')),						new Question('pictures/8.jpg', 'Where is a fork?', $this->getReference('categoryPrzyimki')),			new Question('pictures/8.jpg', 'What is on a plate near fork?', $this->getReference('categoryRzeczy')),						new Question('pictures/9.jpg', 'Where is the sticky tape?', $this->getReference('categoryPrzyimki')),			new Question('pictures/9.jpg', 'Where are scissors?', $this->getReference('categoryPrzyimki')),						new Question('pictures/10.jpg', 'What animals can you see in the picture?', $this->getReference('categoryZwierzeta')),						new Question('pictures/11.jpg', 'What child is pointing?', $this->getReference('categoryZwierzeta')),						new Question('pictures/12.jpg', 'What are children doing?', $this->getReference('categoryCzasowniki')),						new Question('pictures/13.jpg', 'Where is a man?', $this->getReference('categoryPrzyimki')),			new Question('pictures/13.jpg', 'Who is a man feeding?', $this->getReference('categoryZwierzeta')),						new Question('pictures/15.jpg', 'Where is the towel?', $this->getReference('categoryPrzyimki')),						new Question('pictures/19.jpg', 'What can you see in the foreground?', $this->getReference('categoryRzeczy')),						new Question('pictures/20.jpg', 'What fruit can you see in the picture?', $this->getReference('categoryRzeczy')),						new Question('pictures/21.jpg', 'What fruits can you see in the picture?', $this->getReference('categoryRzeczy')),						new Question('pictures/25.jpg', 'What children are doing?', $this->getReference('categoryCzasowniki')),						new Question('pictures/26.jpg', 'What animal can you see in the picture?', $this->getReference('categoryZwierzeta')),						new Question('pictures/27.jpg', 'What animal can you see in the picture?', $this->getReference('categoryZwierzeta')),						new Question('pictures/28.jpg', 'What is man doing?', $this->getReference('categoryCzasowniki')),						new Question('pictures/29.jpg', 'What is girl doing?', $this->getReference('categoryCzasowniki')),						new Question('pictures/30.jpg', 'What are people doing?', $this->getReference('categoryCzasowniki')),		);				foreach($questions as $i => $question) {			$em->persist($question);			$this->addReference('question'.$i, $question);		}        		$em->flush();    }	    /**     * {@inheritDoc}     */    public function getOrder()    {        return 2; // the order in which fixtures will be loaded    }}