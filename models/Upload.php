<?
namespace app\modules\freelance\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\imagine\Image;

class Upload extends Model
{
    /**
     * @var UploadedFile
     */
    public $upFile;

    public function rules()
    {
        return [
            [['upFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, tmp'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
            $this->upFile->saveAs( 'uploads/'.$this->upFile->baseName . '.' . $this->upFile->extension);
            return true;
        } else {
            return false;
        }
    }
	
	public function uploadThumb()
    {
        if ($this->validate()) {
			Image::thumbnail();
            $this->upFile->saveAs( 'uploads/'.$this->upFile->baseName . '.' . $this->upFile->extension);
            return true;
        } else {
            return false;
        }
    }
}