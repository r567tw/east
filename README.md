# Demo

## 想玩的

- [] Redis or Queue ...etc
- [] Vultr
- [] Broadcast: https://laravel.com/docs/11.x/broadcasting

> 唯二不推薦「Regular Cloud Compute (畫面這個)」和「Intel High Performance」

- 租一個 一個月 6~12 美元(約 195~400 元台幣), 做這個專案永遠的家。
- https://1hr.website/vultr-vps-tutorial/#%E6%96%B0%E6%89%8B%E6%83%B3%E6%89%BE%E4%BE%BF%E5%AE%9C_VPS_%E6%9C%89%E5%93%AA%E4%BA%9B%E6%8E%A8%E8%96%A6%E9%81%B8%E6%93%87%EF%BC%9F

- 短網址系統 開發
- 學習 n8n
- 學習 mcp
- 考 AWS 證照：https://www.dcard.tw/f/exam/p/240801516

## 部署到 Vultr

https://sivabalanb.medium.com/deploy-react-app-to-vps-digitalocean-vultr-using-git-actions-5766be8d2961

> garygrossgarten/github-action-scp@release

## Filament php

https://filamentphp.com/docs/3.x/panels/getting-started

## 安裝

https://www.digitalocean.com/community/tutorials/how-to-install-lamp-stack-on-ubuntu

> 你建議 一個測試站 laravel , 可能會用到 cache redis 和 一些 supervisor queue meilsearch 等進階功能 但只是給開發人員的玩具 開發人員測試用的 side project 網站, 你認為在 vultr 上要開怎麼樣的機器 希望越低越好

> 綜合考量，建議選擇 Regular Performance $10/月方案 作為起點，若在實際使用中發現效能不足，可升級至 High Performance 或 High Frequency $12/月方案。

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ToRomanController extends Controller
{
    public function convertToRoman(Request $request)
    {
        $number = $request->input('number');

        // Validate the input
        if (!is_numeric($number) || $number < 1 || $number > 3999) {
            return response()->json(['error' => 'Invalid number. Please enter a number between 1 and 3999.'], 400);
        }

        $romanNumeral = $this->toRoman((int)$number);

        return response()->json(['roman' => $romanNumeral]);
    }

    public function toRoman($number)
    {
        $map = [
            1000 => 'M',
            900 => 'CM',
            500 => 'D',
            400 => 'CD',
            100 => 'C',
            90 => 'XC',
            50 => 'L',
            40 => 'XL',
            10 => 'X',
            9 => 'IX',
            5 => 'V',
            4 => 'IV',
            1 => 'I'
        ];

        $result = '';

        foreach ($map as $value => $symbol) {
            while ($number >= $value) {
                $result .= $symbol;
                $number -= $value;
            }
        }

        return $result;
    }
}

```

### Deploy to Vultr Github action

```yaml
# .github/workflows/deploy.yml

name: Deploy to EC2

on:
  push:
    branches:
      - develop

jobs:
  deploy:
    runs-on: ubuntu-latest

    steps:
      - name: Checkout code
        uses: actions/checkout@v3

      - name: Setup Node.js
        uses: actions/setup-node@v3
        with:
          node-version: 18

      - name: Install JS dependencies and build
        run: |
          npm ci
          npm run build

      - name: Set up SSH
        uses: webfactory/ssh-agent@v0.9.0
        with:
          ssh-private-key: ${{ secrets.EC2_PRIVATE_KEY }}

      - name: Set up known hosts
        run: |
          mkdir -p ~/.ssh
          ssh-keyscan -H ${{ secrets.EC2_HOST }} >> ~/.ssh/known_hosts

      - name: Deploy to EC2
        run: |

          ssh ${{ secrets.EC2_USER }}@${{ secrets.EC2_HOST }} << 'EOF'
                ,,,,
                composer install ...
          EOF
```
