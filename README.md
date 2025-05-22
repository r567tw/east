# Demo

## 想玩的

- [] Redis or Queue ...etc
- [] Vultr
- [] Broadcast: https://laravel.com/docs/11.x/broadcasting
- [] 短網址

## 部署到 Vultr

https://sivabalanb.medium.com/deploy-react-app-to-vps-digitalocean-vultr-using-git-actions-5766be8d2961

> 你建議 一個測試站 laravel , 可能會用到 cache redis 和 一些 supervisor queue meilsearch 等進階功能 但只是給開發人員的玩具 開發人員測試用的 side project 網站, 你認為在 vultr 上要開怎麼樣的機器 希望越低越好

> 綜合考量，建議選擇 Regular Performance $10/月方案 作為起點，若在實際使用中發現效能不足，可升級至 High Performance 或 High Frequency $12/月方案。

> 唯二不推薦「Regular Cloud Compute (畫面這個)」和「Intel High Performance」

- **租一個 一個月 6~12 美元(約 195~400 元台幣), 做這個專案永遠的家。**

## Deploy to Vultr Github action

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
