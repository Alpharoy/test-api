#!/bin/bash

build(){
  echo 'Start Build:'

  case $1 in
    dev)
        #研发环境
        build_dev
        ;;
    test)
        #测试环境
        build_dev
        ;;
    pre)
        #预发布环境
        build_prod
        ;;
    prod)
        #生产环境
        build_prod
        ;;
    *)
        echo "Usage: sh $0 build {dev|test|pre|prod}"
    esac
}

build_dev(){
  echo 'DEV'

  #检查是否安装 composer
  if ! command -v composer >/dev/null 2>&1; then
        echo '命令 composer 不存在, 请安装后执行本脚本'
        exit 7
  fi

   #composer 安装PHP依赖
   if ! composer --dev --no-progress install; then
        echo 'composer install 失败'
        exit 7
   fi

  #删除 storage 目录
  rm -rf storage/
}

build_prod(){
  echo 'PROD'

  SHELL_FOLDER=$(cd "$(dirname "$0")";pwd)
  cd $SHELL_FOLDER

  #检查是否安装 composer
  if ! command -v composer >/dev/null 2>&1; then
        echo '命令 composer 不存在, 请安装后执行本脚本'
        exit 7
  fi

  #composer 安装PHP依赖
  if ! composer --no-dev --optimize-autoloader --no-progress install; then
        echo 'composer install 失败'
        exit 7
  fi


  #删除 storage 目录
  rm -rf storage/
}

getconfig(){
  config_files='.env'
  echo $config_files
}

createdir(){
  echo '创建相关目录'
}

setpermission(){
  SHELL_FOLDER=$(cd "$(dirname "$0")";pwd)
  cd $SHELL_FOLDER

  writable_dir=('bootstrap/cache/')
  for dir in ${writable_dir[@]};do
    mkdir -p $dir
    chown -R $1 $dir
  done
}

#接收两个参数
# $1 为用户
# $2 为共享目录
link(){
    echo '[创建软链]'

    SHELL_FOLDER=$(cd "$(dirname "$0")";pwd)

    if [ $# -eq 2 ];then
        ln -sv ${2}/storage ${SHELL_FOLDER}/storage
        chown ${1}.${1} -R ${SHELL_FOLDER}/storage
        setfacl -m u:$1:rwx -R ${SHELL_FOLDER}/storage
    fi
}

initproject(){
    echo '初始化项目'

    SHELL_FOLDER=$(cd "$(dirname "$0")";pwd)
    cd $SHELL_FOLDER

    sudo -u $1 php artisan init
}

updatenode(){
    echo '更新权限节点'

    SHELL_FOLDER=$(cd "$(dirname "$0")";pwd)
    cd $SHELL_FOLDER

    sudo -u $1 php artisan node:update
}

case $1 in
    build)
        build $2
        ;;
    getconfig)
        getconfig
        ;;
    setpermission)
        #传递一个用户进去，修改相应权限
        setpermission $2
        link $2 $3
        ;;
    *)
        echo "Usage: sh $0 {build|getconfig|setpermission}"
esac
