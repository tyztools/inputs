# readme
参数接收，示例入下:
```php
use Tyz\Inputs\Input;
$input = new Input();
//单个参数接收
$input->intVar("age", "age1", "33", true);
$input->arrayVar("info", "info", false, false, [function($data){return json_decode($data, true);}]);
//批量接收
$input->typeVarMulti("string", ["name" => "name1", "label" => "label2"], "");
//parsed解析
$data = [];
$input->parsed($data, $this->request->getQueryParams());
```