<?phpnamespace ZPIBundle\DataFixtures\ORM;use Doctrine\Common\DataFixtures\AbstractFixture;use Doctrine\Common\DataFixtures\OrderedFixtureInterface;use Doctrine\Common\Persistence\ObjectManager;use ZPIBundle\Entity\Question;class LoadQuestionData extends AbstractFixture implements OrderedFixtureInterface{    /**     * {@inheritDoc}     */    public function load(ObjectManager $em)    {		$question1 = new Question('pictures/food/food1.jpg', 'Where is a cat?', $this->getReference("cat1"));		$question2 = new Question('pictures/food/food2.jpg', 'I like potatoes...', $this->getReference("cat1"));		$question3 = new Question('pictures/food/food3.jpg', 'What can you see on the picture?', $this->getReference("cat1"));		$question4 = new Question('pictures/pokemon/pokemon1.png', 'Who can you see behind Lickilicky?', $this->getReference("cat2"));		$question5 = new Question('pictures/pokemon/pokemon2.png', 'Where is Pikachu?', $this->getReference("cat2"));		$question6 = new Question('pictures/pokemon/pokemon3.jpg', 'Where is Bulbasaur situated?', $this->getReference("cat2"));		$question7 = new Question('pictures/pokemon/pokemon4.jpg', 'Where can you find Team Rocket?', $this->getReference("cat2"));				$em->persist($question1);		$em->persist($question2);		$em->persist($question3);		$em->persist($question4);		$em->persist($question5);		$em->persist($question6);		$em->persist($question7);        		$em->flush();    }	    /**     * {@inheritDoc}     */    public function getOrder()    {        return 2; // the order in which fixtures will be loaded    }}