<?

define ('POST', 'post');
define ('GET', 'get');

class Input
{
	protected $value=null;
	protected $name=null;
	protected $id=null;
	protected $type=null;
	protected $label=null;
	
	public function __construct($type, $id, $name, $value, $label)
	{
		$this->type = $type;
		$this->id = $id;
		$this->name = $name;
		$this->value = $value;
		$this->label = $label;
	}
	
	public function __toString()
	{
		$retVal = "<tr><td>";
 		$retVal = $retVal."$this->label";
		$retVal .= "</td>";
		$retVal .= "<td>";
		$retVal .= "<input type='$this->type' value='$this->value' name='$this->name' id='$this->id'></input>";
		$retVal .= "</td></tr>";
		
		return $retVal;
	}
}

function showForm($inputs, $action, $method)
{
	print "<form method='$method' action='$action'>";
	print "<table>";
	foreach ($inputs as $input)
	{
		print $input;
	}
	print "</table>";
	print "</form>";
}

?>
