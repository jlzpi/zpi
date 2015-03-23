<?phpnamespace ZPIBundle\DataFixtures\ORM;use Doctrine\Common\DataFixtures\AbstractFixture;use Doctrine\Common\DataFixtures\OrderedFixtureInterface;use Doctrine\Common\Persistence\ObjectManager;use ZPIBundle\Entity\Category;class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface{    /**     * {@inheritDoc}     */    public function load(ObjectManager $em)    {		$category1 = new Category('food');		$category2 = new Category('pokemon');				$em->persist($category1);		$em->persist($category2);				$em->flush();				$this->addReference('cat1', $category1);		$this->addReference('cat2', $category2);    }	    /**     * {@inheritDoc}     */    public function getOrder()    {        return 1; // the order in which fixtures will be loaded    }}