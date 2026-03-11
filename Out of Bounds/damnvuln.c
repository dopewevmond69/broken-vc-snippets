//https://github.com/hardik05/Damn_Vulnerable_C_Program/blob/master/imgRead.c

#include<stdio.h>
#include<stdlib.h>
#include<string.h>

struct Image
{
	char header[4];
	int width;
	int height;
	char data[10];
};

int ProcessImage(char* filename){

	FILE *fp;
	char ch;
	struct Image img;

	fp = fopen(filename,"r"); 

	if(fp == NULL)
	{
		printf("\nCan't open file or file doesn't exist.");
		exit(0);
	}

	printf("\n\tHeader\twidth\theight\tdata\t\r\n");

	while(fread(&img,sizeof(img),1,fp)>0){
		printf("\n\t%s\t%d\t%d\t%s\r\n",img.header,img.width,img.height,img.data);
	
		// Modified by Rezilant AI, 2026-03-11 14:36:31 GMT, Fixed use-after-free by restructuring conditional logic and adding NULL checks
		int size1 = img.width + img.height;
		char* buff1=(char*)malloc(size1);

		if (buff1 == NULL) {
		    printf("Memory allocation failed\n");
		    fclose(fp);
		    exit(1);
		}

		memcpy(buff1, img.data, sizeof(img.data));

		if (size1/2 == 0) {
		    free(buff1);
		    buff1 = NULL;  // Set to NULL after freeing
		} else {
		    if (size1 == 123456) {
		        buff1[0] = 'a';  // Now this is safe - buff1 is still allocated
		    }
		    free(buff1);  // Free here instead
		    buff1 = NULL;
		}

		// Original Code
		//int size1 = img.width + img.height; //Vulnerability: integer overflow
		//char* buff1=(char*)malloc(size1);
		//
		//memcpy(buff1,img.data,sizeof(img.data)); //Vulnerability: no data buffer size/malloc success check?
		//free(buff1);
		//
		//if (size1/2==0){
		//	free(buff1); //Vulnerability: double free
		//}
		//else{
		//	if(size1 == 123456){
		//		buff1[0]='a'; //Vulnerability: use after free
		//	}
		//}

		int size2 = img.width - img.height+100; //Vulnerability: integer underflow
		//printf("Size1:%d",size1);
		char* buff2=(char*)malloc(size2);

		memcpy(buff2,img.data,sizeof(img.data));

		int size3= img.width/img.height;
		//printf("Size2:%d",size3);

		char buff3[10];
		char* buff4 =(char*)malloc(size3);
		memcpy(buff4,img.data,sizeof(img.data));

		char OOBR_stack = buff3[size3+100]; //Vulnerability: out of bound read (stack)
		char OOBR_heap = buff4[100];

		buff3[size3+100]='c'; //Vulnerability: out of bound write (Stack)
		buff4[100]='c'; //Vulnerability: out of bound write (Heap)

		if(size3>10){
				buff4=0; //memory leak?
		}
		else{
			free(buff4);
		}

		free(buff2);
	}
	fclose(fp);
}

int main(int argc,char **argv)
{
	ProcessImage(argv[1]);
}