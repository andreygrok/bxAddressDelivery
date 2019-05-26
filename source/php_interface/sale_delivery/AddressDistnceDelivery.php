<?
namespace Sale\Handlers\Delivery;

use Bitrix\Sale\Delivery\CalculationResult;
use Bitrix\Sale\Delivery\Services\Base;

class AddressDistnceDelivery extends Base
{
    public static function getClassTitle()
        {
            return 'Доставка по километражу';
        }

    public static function getClassDescription()
        {
            return 'Доставка, стоимость которой зависит от расстояния';
        }



    protected function calculateConcrete(\Bitrix\Sale\Shipment $shipment)
    {
        $result = new CalculationResult();
        $price = floatval($this->config["MAIN"]["PRICE"]);
        $order = $shipment->getCollection()->getOrder();
        $props = $order->getPropertyCollection();

        // получаем текущее значение расчитанного кол-ва километров
        $distance = $props->getItemByOrderPropertyId(21);

        // получаем стоимость одного километра
        $priceKm = $this->config['MAIN']['PRICE_KM'];
        $price = $priceKm * $distance->getValue(); // расчет цены
        $result->setDeliveryPrice(roundEx($price, 2));
        return $result;
    }



    protected function getConfigStructure()
        {
            return array(
                "MAIN" => array(
                    "TITLE" => 'Настройка обработчика',
                    "DESCRIPTION" => 'Настройка обработчика',
                    "ITEMS" => array(
                        "PRICE_KM" => array(
                                    "TYPE" => "STRING",
                                    "MIN" => 0,
                                    "NAME" => 'Стоимость доставки (маска 10:150;20:200;30:450)'
                        ),

                    )
                )
            );
        }

    public function isCalculatePriceImmediately()
        {
            return true;
        }

    public static function whetherAdminExtraServicesShow()
        {
            return true;
        }
}
?>
