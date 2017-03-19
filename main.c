#include <stdio.h>
 
int main()
{
    int n;
    scanf("%d",&n);
    int a[n],max=0,min=9999,flag=0;
    for(int i=0;i<n;i++)
    {
    	scanf("%d",&a[i]);
    	if(a[i]>max)
    	max=a[i];
    	if(a[i]<min)
    	min=a[i];
    }
    for(int j=min;j<=max;j++)
    {
    	flag=0;
    	for(int i=0;i<n;i++)
    	{
    		if(a[i]==j)
    		{
    			flag=1;
    			break;
    		}
    	}
    	if(flag==0)
    	break;
    }
    if(flag==0)
    printf("NO\n");
    else
    printf("YES\n");
}