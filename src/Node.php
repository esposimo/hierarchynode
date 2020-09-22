<?php


namespace smn\hnp;



/**
 * Class Node
 * @package smn\hnp
 *
 *
 *
 */
class Node
{

    /**
     * List of mandatory properties
     * @var array
     */
    protected array $unique_properties = [];


    /**
     * List of key/value properties
     * @var array
     */
    protected array $properties = [];

    /**
     * Value of Node
     * @var mixed
     */
    protected $value;


    /**
     * List of children
     * @var Node[]
     */
    protected array $children = [];


    /**
     * Parent of Node
     * @var Node|null
     */
    protected ?Node $parent = null;


    /**
     * Node constructor.
     * Il costruttore prevede due parametri. Il primo è obbligatorio ed è il valore del nodo (può essere un oggetto, una stringa, un intero)
     * Il secondo parametro è un array. Se non specificato sarà utilizzato un array di default.
     * Questo array è in formato key/value e rappresenta l'insieme delle proprietà da assegnare al Nodo. Le chiavi sono i nomi delle proprietà, i valori i rispettivi valori delle proprietà.
     * In questo array è necessario indicare ALMENO tutte le proprietà obbligatorie del nodo. Le proprietà obbligatorie sono dichiarate in $unique_properties.
     * @param $value Valore da assegnare al nodo
     * @param array $properties Lista in formato chiave/valore delle proprietà da assegnare al nodo. Devono essere presenti almeno le proprietà obbligatorie
     * @throws NodeException Lanciata quando in $properties non ci sono almeno le proprietà obbligatorie
     */
    public function __construct($value, array $properties = [])
    {
        if (!$this->isKeyMandatoryPresent($properties)) {
            throw new NodeException('le chiavi indicate non corrispondono almeno le chiavi obbligatorie');
        }
        $this->unique_properties = array_change_key_case($this->unique_properties, CASE_LOWER);
        $this->setValue($value);
        // check sulle properties , vedi l'istanza vecchia
        foreach ($properties as $property_name => $property_value) {
            $this->setProperty($property_name, $property_value);
        }

    }


    /**
     * Verifica se tra le chiavi dell'array $properties ci sono ALMENO le chiavi obbligatorie di questa istanza
     * @param array $properties
     * @return bool
     */
    public function isKeyMandatoryPresent(array $properties = []): bool
    {
        // filter $properties per eliminare chiavi/valori in più rispetto a quelle obbligatorie
        $filter = array_intersect($this->unique_properties, array_keys($properties));
        // confronto $filter (che contiene solo le eventuali chiavi obbligatorie inserite in $properties)
        // con le chiavi obbligatorie dell'istanza
        // dato che ho creato array con i valori delle chiavi, uso il metodo di compare sui valori
        return self::_compareArrayValue($filter, $this->unique_properties);
    }

    /**
     * Verifica se nell'array $properties ci sono ALMENO le coppie chiavi/valore obbligatorie
     * Restituisce true se $properties è uguale alle coppie chiavi/valore obbligatorie configurate in questa istanza
     * @param array $properties
     */
    public function isKeyAndValueMandatoryPresent(array $properties = [])
    {
        // filtro $properties per eliminare chiavi/valori in più
        $filter = array_intersect_key($properties, array_flip($this->unique_properties));
        // come sopra, ma confronto l'intersezione delle proprietà uniche (valori compresi) con le coppie chiavi/valori delle sole proprietà uniche di questa istanza
        return $this->_compareArrayKeysAndValue($filter, $this->getMandatoryPropertiesKeyValue());

    }


    /**
     * Restituisce la lista delle chiavi obbligatorie obbligatorie
     * @return array
     */
    public function getMandatoryPropertiesKey()
    {
        return $this->unique_properties;
    }

    /**
     * Restituisce un array nel formato chiave/valore contenente solo le proprietà obbligatorie
     * @return array
     */
    public function getMandatoryPropertiesKeyValue()
    {
        $return = [];
        foreach ($this->unique_properties as $property_name) {
            $return[$property_name] = $this->getProperty($property_name);
        }
        return $return;
    }

    /**
     * Restituisce tutti i nomi delle proprietà del nodo
     * @return array
     */
    public function getPropertiesKey()
    {
        return array_keys($this->properties);
    }

    /**
     * Restituisce tutte le proprietà del nodo
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Restituisce il valore della proprietà $property_name
     * @param string $property_name
     * @return mixed|null
     */
    public function getProperty(string $property_name)
    {
        return $this->hasProperty($property_name) ? $this->properties[$property_name] : null;
    }

    /**
     * Configura la proprietà $property_name con valore $value
     * @param string $property_name
     * @param $property_value
     */
    public function setProperty(string $property_name, $property_value)
    {
        $this->properties[$property_name] = $property_value;
    }


    /**
     * Restituisce true/false se la proprietà $property_name esiste
     * @param string $property_name
     * @return bool
     */
    public function hasProperty(string $property_name)
    {
        return array_key_exists($property_name, $this->properties);
    }

    /**
     * Restituisce true o false se una chiave è obbligatoria
     * @param string $property_name
     * @return bool
     */
    public function isMandatoryKey(string $property_name)
    {
        return array_search($property_name, $this->unique_properties) !== false;
    }

    /**
     * Return true or false if two array are equal in key/value (no check element position)
     * @param array $a
     * @param array $b
     * @return bool
     */
    private static function _compareArrayKeysAndValue(array $a, array $b)
    {
        return (
            is_array($a)
            && is_array($b)
            && count($a) == count($b)
            && array_diff_assoc($a, $b) === array_diff_assoc($b, $a)
        );
    }

    /**
     * Return true or false if two array are equal in values (no check element position)
     * @param array $a
     * @param array $b
     * @return bool
     */
    public static function _compareArrayValue(array $a, array $b)
    {
        // https://stackoverflow.com/questions/5678959/php-check-if-two-arrays-are-equal
        return (
            is_array($a)
            && is_array($b)
            && count($a) == count($b)
            && array_diff($a, $b) === array_diff($b, $a)
        );
    }

    /**
     * Aggiunge un nodo alla lista dei figli
     * @param $value
     * @param array $properties
     */
    public function addNode($value, array $properties = [])
    {
        // in $properties devono esserci almeno i parametri obbligatori del padre
        // se ci sono, non devono essere uguali
        // se non sono uguali, aggiungi
        // se sono uguali, non aggiungi

        if ($this->isKeyMandatoryPresent($properties)) {
            // se le chiavi sono presenti, verifico che non hanno gli stessi valori del padre
            if ($this->isKeyAndValueMandatoryPresent($properties)) {
                // se sono uguali, exception
                throw new NodeException('le proprietà obbligatorie del figlio sono le stesse del padre');
            }
            $node = new static($value, $properties);
            $this->children[] = $node;
            $node->parent = $this;
        }
        else {
            throw new NodeException(sprintf('in properties non esistono i parametri obbligatori (%s)', implode(',', $this->getMandatoryPropertiesKey())));
        }
    }

    /**
     * Configura il padre del Nodo
     * @param $value
     * @param array $properties
     */
    public function setParent($value, array $properties = [])
    {
        if ($this->isKeyMandatoryPresent($properties)) {
            // se le chiavi sono presenti, verifico che non ci sia un figlio con gli stessi valori
            if ($this->isKeyAndValueMandatoryPresent($properties)) {
                throw new NodeException('le proprietà obbligatorie del figlio sono le stesse del padre');
            }
            $node = new static($value, $properties);
            $this->parent = $node;
            $node->children[] = $this;
        }
        else
        {
            throw new NodeException(sprintf('in properties non esistono i parametri obbligatori (%s)', implode(',', $this->getMandatoryPropertiesKey())));
        }
    }

    /**
     * Restituisce il nodo padre
     * @return Node
     */
    public function getParent(): Node
    {
        return $this->parent;
    }

    /**
     * Restituisce true o false se il nodo ha un padre
     * @return bool
     */
    public function hasParent(): bool
    {
        return ($this->parent === null) ? false : true;
    }

    /**
     * Restituisce il numero di figli
     * @return int
     */
    public function getCountChildren(): int
    {
        return count($this->children);
    }

    /**
     * Restituisce il nodo root
     * @return Node
     */
    public function getAncestral(): ?Node
    {
        return (is_null($this->parent)) ? $this : $this->getParent()->getAncestral();
    }


    /**
     * Restituisce il nodo con le proprietà $properties. Se non esiste, restituisce null.
     * Di $properties verranno considerate solo le proprietà obbligatorie
     * @param array $properties
     * @return Node|null
     */
    public function getNode(array $properties = []): ?Node
    {
        foreach ($this->children as $node) {
            if ($node->isKeyAndValueMandatoryPresent($properties)) {
                return $node;
            }
        }
        return null;
    }


    /**
     * Restituisce i nodi che hanno le proprietà indicate
     * @param array $properties
     * @return Node[]
     */
    public function getNodes(array $properties = []): array
    {
        $return = array();
        foreach ($this->children as $position => $node) {
            $intersect = array_intersect_assoc(
                $node->getProperties(),
                $properties
            );
            if (self::_compareArrayKeysAndValue($intersect, $properties)) {
                $return[] = $node;
            }
        }
        return $return;
    }


    /**
     * Restituisce tutti i nodi figli
     * @return Node[]
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * Rimuove il nodo con le proprietà $properties
     * @param array $properties
     */
    public function removeNode(array $properties = [])
    {
        foreach ($this->children as $position => $node) {
            if ($node->isKeyAndValueMandatoryPresent($properties)) {
                unset($this->children[$position]);
            }
        }
    }


    /**
     * Rimuove i figli con queste proprietà. Non effettua check su obbligatori e opzionali
     * @param array $properties
     */
    public function removeChildren(array $properties = [])
    {
        foreach ($this->children as $position => $node) {
            $intersect = array_intersect_assoc(
                    $node->getProperties(),
                    $properties
                );
            if (self::_compareArrayKeysAndValue($intersect, $properties)) {
                unset($this->children[$position]);
            }
        }
    }


    /**
     * Rimuove i figli con il valore $value
     * @param $value
     */
    public function removeChildrenByValue($value)
    {
        foreach ($this->children as $x => $node) {
            if ($node->getValue() === $value) {
                unset($this->children[$x]);
            }
        }
    }


    /**
     * Configura il valore
     * @param $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Restituisce il valore del nodo
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

}