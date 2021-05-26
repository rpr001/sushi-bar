<?php


namespace SushiBar;

use InvalidArgumentException;

class RestApi
{
    /** @var string $requestMethod */
    protected $requestMethod;
    /** @var string $payload  */
    protected $payload;
    /** @var SushiMaster $sushiMaster */
    protected $sushiMaster;

    public function __construct(string $requestMethod)
    {
        $this->requestMethod = $requestMethod;
        $this->payload = file_get_contents('php://input');

        $table = array_key_exists('table', $_SESSION) ? $_SESSION['table'] : new CircularTable(SushiMaster::SEATS_PER_TABLE);
        $this->sushiMaster = new SushiMaster($table);
    }

    public function handleRequest(): void
    {
        switch ($this->requestMethod) {
            case 'GET':
                header('Content-Type: text/html; charset=utf-8');
                $view = new View(['seats' => $this->sushiMaster->getTable()->toHash()]);
                $view->render(dirname(__FILE__) . '/../../views/index.html.php');
                break;
            case 'POST':
                header('Content-Type: application/json; charset=utf-8');

                try {
                    $groupId = strtoupper(uniqid());
                    $this->sushiMaster->addGroup($groupId, intval($this->getJsonPayload()['numGuests']));
                    $_SESSION['table'] = $this->sushiMaster->getTable();
                    header('HTTP/1.1 201 Created');
                    echo json_encode($this->sushiMaster->getTable()->toHash());
                } catch (InvalidArgumentException $exception) {
                    header('HTTP/1.1 422 Unprocessable Entity');
                    echo json_encode(['error' => $exception->getMessage()]);
                }

                break;
            case 'DELETE':
                header('Content-Type: application/json; charset=utf-8');

                try {
                    $groupId = strval($this->getJsonPayload()['groupId']);
                    if(!$groupId) {
                        throw new InvalidArgumentException('Ungültige Gruppen-ID');
                    }
                    $this->sushiMaster->removeGroup($groupId);
                    $_SESSION['table'] = $this->sushiMaster->getTable();
                    header('HTTP/1.1 200 OK');
                    echo json_encode($this->sushiMaster->getTable()->toHash());
                } catch (InvalidArgumentException $exception) {
                    header('HTTP/1.1 422 Unprocessable Entity');
                    echo json_encode(['error' => $exception->getMessage()]);
                }
                break;
        }
    }

    protected function getJsonPayload() : array
    {
        return json_decode($this->payload, true);
    }
}