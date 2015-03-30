#!/bin/bash 
db_user=phuckhang
db_pass=phuckhang
db_name=phuckhang
db_host=localhost

echo "========================================================="
echo db_user is ${db_user}
echo db_pass is ${db_pass}
echo db_name is ${db_name}
echo db_host is ${db_host}

working_folder=`dirname $0`
echo working_folder is ${working_folder}
FILES=./*.sql
cd ${working_folder}

echo "========================================================="
script_file_pattern=\d*_.*.sql
for script_file in $FILES
do
	if [ -e "${script_file}" ]; then
		load_command="mysql --user=${db_user} --password=${db_pass} ${db_name} < '${script_file}'"
		echo ${file_counter}". Start loading file " ${script_file} "..."
		eval "${load_command}"
		let file_counter=file_counter+1
	fi
done
echo "========================================================="
echo "FINISHED!"
