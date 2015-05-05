<?phpnamespace ZPIBundle\DataFixtures\ORM;use Doctrine\Common\DataFixtures\AbstractFixture;use Doctrine\Common\DataFixtures\OrderedFixtureInterface;use Doctrine\Common\Persistence\ObjectManager;use ZPIBundle\Entity\Question;class LoadQuestionData extends AbstractFixture implements OrderedFixtureInterface{    /**     * {@inheritDoc}     */    public function load(ObjectManager $em)    {		$questions = array(			new Question('pictures/[category]/[picture]', '[question]', $this->getReference('categoryPrzyimki'))		);				foreach($questions as $i => $question) {			$em->persist($question);			$this->addReference('question'.$i, $question);		}        		$em->flush();    }	    /**     * {@inheritDoc}     */    public function getOrder()    {        return 2; // the order in which fixtures will be loaded    }}