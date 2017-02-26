<?php


namespace iTymz\JMeterTests\Model;


/**
 * Class FileExporter
 *
 * @package iTymz\JMeterTests\Model
 */
class FileExporter
{
    /**
     * Saving your site map as csv file
     *
     * @param array $data
     */
    public function exportDataToCsv(array $data)
    {
        foreach ($data as $site => $siteData) {
            $fp = fopen(__DIR__ . '/../../var/' . $site . '.csv', 'w');
            if (!empty($siteData)) {
                fputcsv($fp, array_merge(['line'], array_keys($siteData[0])));
                for ($i = 0; $i < count($siteData); $i++) {
                    fputcsv($fp, array_merge([$i], $siteData[$i]));
                }
            }
            fclose($fp);
        }
    }
}