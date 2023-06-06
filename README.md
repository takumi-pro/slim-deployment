## 開発環境DB

postgres開始
```bash
make up
```

postgres停止
```bash
make down
```

## インフラ構築

### EC2にphp8.1を導入する
以下の記事を参考に進めた
- [PHP7.4からPHP8.1へバージョンアップした - EC2（Amazon Linux2）/ Nginx](https://zenn.dev/ta2_root/articles/09634627f791bb)

### CodeDeployによるデプロイ
プロジェクトルート配下に`appspec.yml`を配置

```yaml
version: 0.0
os: linux
files:
  - source: /
    destination: /var/www/html
permissions:
  - object: /var/www/html/
    pattern: "**"
    owner: apache
    group: apache
hooks:
  ApplicationStart:
    - location: scripts/start_server.sh
      timeout: 300
      runas: root
  ApplicationStop:
    - location: scripts/stop_server.sh
      timeout: 300
      runas: root
```

対象のEC2に以下の以下のポリシーのあるロールを付与

```json
{
    "Version": "2012-10-17",
    "Statement": [
        {
            "Action": [
                "s3:GetObject",
                "s3:GetObjectVersion",
                "s3:ListBucket"
            ],
            "Effect": "Allow",
            "Resource": "*"
        }
    ]
}
```

対象のEC2にデプロイエージェントをインストールする
```bash
sudo yum update
sudo yum install ruby
sudo yum install wget
cd /home/ec2-user
wget https://bucket-name.s3.region-identifier.amazonaws.com/latest/install
chmod +x ./install
sudo ./install auto
```


## 参考
- https://qiita.com/harukisan/items/6ac138619d0c9131904c
- [Amazon Linux または RHEL 用のCodeDeploy Agent をインストールする](https://docs.aws.amazon.com/ja_jp/codedeploy/latest/userguide/codedeploy-agent-operations-install-linux.html)