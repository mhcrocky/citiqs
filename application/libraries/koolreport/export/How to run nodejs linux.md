1. Bug fix: in case of libstdc++.so.6 error try to replace lampp lib's one with user lib's one:

# cp /usr/lib/x86_64-linux-gnu/libstdc++.so.6 /opt/lampp/lib/

2. export PATH=$PATH:/opt/lampp/htdocs/koolreport-test/koolreport/packages/export/node-v8.11.2-linux-x64/bin
2. export PATH=$PATH:/home/sgcoth/public_html/koolreport/sabina/vendor/koolphp/koolreport/koolreport/packages/export/node-v7.6.0-linux-x64/bin
2. export PATH=$PATH:/srv/users/koolphp/apps/koolreport/koolreport/packages/export/node-v8.11.2-linux-x64/bin

chown -R dong:dong /opt/lampp/htdocs

find /opt/lampp/htdocs -type d -print0 | xargs -0 sudo chmod 775