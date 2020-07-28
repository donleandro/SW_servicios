set -e

echo "####################################"
echo "Creando imagen Wordpress Plantilla SWMasp Uniandes"
echo "####################################"

rm wordpress.tar || true

echo "####################################"
echo "Moviendo folder _uploads"
echo "####################################"

mv wordpress/wp-content/uploads wordpress/wp-content/_uploads || true

echo "####################################"
echo "Creando tar"
echo "####################################"

cd wordpress/ && tar -czvf ../wordpress.tar . && cd ..

echo "####################################"
echo "Otorgando permisos"
echo "####################################"

chmod 777 -R wordpress.tar

echo "####################################"
echo "Compilando imagen"
echo "####################################"
docker build . -t sitiosweb/sw-wordpress-masp-fpm:1.0.0

exec "$@"

#docker tag sitiosweb/sw-wordpress-masp-fpm:1.0.0 andescontainers.azurecr.io/sw-wordpress-masp-fpm:1.0.0
#docker push andescontainers.azurecr.io/sw-wordpress-masp-fpm:1.0.0