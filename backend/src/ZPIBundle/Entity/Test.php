<?phpnamespace ZPIBundle\Entity;use Doctrine\ORM\EntityRepository;use Doctrine\ORM\Mapping as ORM;/** * @ORM\Entity(repositoryClass="ZPIBundle\Entity\TestRepository") * @ORM\Table(name="test") */class Test{    /**     * @ORM\Column(type="integer")     * @ORM\Id     * @ORM\GeneratedValue(strategy="AUTO")     */    public $id;    /**     * @ORM\Column(type="string", length=100)     */    public $name;    /**     * @ORM\Column(type="decimal", scale=2)     */    public $price;    /**     * @ORM\Column(type="text")     */    public $description;}