<?php


namespace frontend\models;


use common\models\User;
use common\models\UserAddress;
use yii\base\Model;

/**
 * Class ProfileEditForm
 * @property $login;
 * @property $email;
 * @property $firstname;
 * @property $lastname;
 * @property $address;
 * @property $city;
 * @property $state;
 * @property $country;
 * @property $zipcode;
 *
 * @property-read User $user
 * @property-read UserAddress $userAddress
 */
class ProfileEditForm extends Model
{
    public $login;
    public $email;
    public $firstname;
    public $lastname;
    public $address;
    public $city;
    public $state;
    public $country;
    public $zipcode;

    private $user;
    private $userAddress;

    public function __construct($id, $config = [])
    {
        $this->user = User::findIdentity($id);
        $this->userAddress = $this->user->address ?? false;

        if(!$this->userAddress){
            $this->userAddress = new UserAddress();
            $this->userAddress->user_id = $this->user->id;
        }

        $this->login = $this->user->login;
        $this->email = $this->user->email;
        $this->firstname = $this->user->firstname;
        $this->lastname = $this->user->lastname;
        $this->address = $this->userAddress->address;
        $this->city = $this->userAddress->city;
        $this->state = $this->userAddress->state;
        $this->country = $this->userAddress->country;
        $this->zipcode = $this->userAddress->zipcode;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['login', 'email', 'address', 'city', 'state', 'country', 'firstname', 'lastname'], 'required'],
            [['firstname', 'lastname'], 'string', 'max' => 255],
            [['address', 'city', 'state', 'country', 'zipcode'], 'string', 'max' => 255],
        ];
    }

    public function edit(): bool
    {
        if (!$this->validate()) {
            return false;
        }
        $this->user->firstname = $this->firstname;
        $this->user->lastname = $this->lastname;
        $this->userAddress->address = $this->address;
        $this->userAddress->city = $this->city;
        $this->userAddress->state = $this->state;
        $this->userAddress->country = $this->country;
        $this->userAddress->zipcode = $this->zipcode;
        return $this->user->save() && $this->userAddress->save();
    }
}