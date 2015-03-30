#!/bin/bash 
db_user=phuckhang
db_pass=phuckhang
db_name=phuckhang
db_host=localhost

echo "=========================================================";
echo db_user is ${db_user};
echo db_pass is ${db_pass};
echo db_name is ${db_name};
echo db_host is ${db_host};

working_folder=`dirname $0`;
cd ${working_folder};

file_counter=1;
COUNTER=1
echo "=========================================================";
while [ $COUNTER -lt 50 ]; do
	script_file_pattern=${COUNTER}_*.sql;
	for script_file in "$(find ${working_folder} -type f -name ${script_file_pattern})"; do
		if [ -e "${script_file}" ]; then
			load_command="mysql --user=${db_user} --password=${db_pass} ${db_name} < '${script_file}'";
			echo ${file_counter}". Start loading file " ${script_file} "...";
			eval "${load_command}";
			let file_counter=file_counter+1;
		fi
	done
	let COUNTER=COUNTER+1;
done
echo "=========================================================";
echo "FINISHED!";
