<?php
/**
 * ���򿪷����ͳ�����
 * ֧����̳��www.bimy.net
 * �ɼ���ѯQQ��624933156
 * �ɼ�������ӿ� For Destoon
 * ֧��POST��GET���ַ�ʽ��������
���磺
����ģ�����ɷ��� http://www.xxx.com/api/caiji.php?moduleid=21&catid=1&title=���Ա���&content=��������
 * ��ȡ��Ŀ��������� http://www.xxx.com/api/caiji.php?moduleid=21&action=cat
 * ����״̬��ֱ���������ע���ж�
 * Ϊ��ϵͳ��ȫ��ǿ�ҽ����޸�spider.php�ļ���
 */
$verify=0;//�Ƿ��������֤��1����0�ر�
$auth = 'dt123456'; //��֤��Կ ����6λ
$spider_status = 2; //��Ϣ״̬ 2Ϊ����� 3Ϊͨ�� 0Ϊͨ���������
$emaildomain="163.com";//�û������������ɼ����������ʱ����û�ָ��һ������,��ʽΪ��username@emaildomain
$prefix='';//�û���ǰ׺�����ɼ������û���ǰ�����ַ�������������ʵ��Ա����Ϊ��
$suffix='';//�û�����׺�����ɼ������û���ǰ�����ַ�������������ʵ��Ա����Ϊ��
$width='80';//����ͼ���
$height='80';//����ͼ���
$randskin=0;//��ҵ��վ���ģ�棬1������0�ر� ��Ҫ�ں�̨�û����������ҵ��Աʹ��ģ�湦��
$debug=0;//����ģʽ��1������0�ر� �Ų�BUGר��,ƽʱ��ر�
$logfile='caijilog.txt';//������־,����վ��Ŀ¼��,�뱣֤���ļ�����Ȩ��Ϊ��д.linuxΪ777Ȩ��
	
define('DT_ADMIN', true);
require '../common.inc.php';
error_reporting(0);
include $CFG['charset'].'function.php';

